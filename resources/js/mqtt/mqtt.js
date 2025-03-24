import { SystemAccess } from './system-access.ts';

/**
 *  Import MQTT Scripts
 */
import mqtt from 'mqtt';
const clientId = 'tms.sogfbih_' + Math.random().toString(16).substr(2, 8);

/** MQTT CozyFirm over WSS */
const host = 'wss://mqtt.cozyfirm.com:8083';
/** MQTT Main topic */
let mainTopic = "tms.sogfbih";

const options = {
    keepalive: 30,
    clientId,
    protocolId: 'MQTT',
    protocolVersion: 4,
    clean: true,
    reconnectPeriod: 1000,
    connectTimeout: 30 * 1000,
    will: {
        topic: 'WillMsg',
        payload: 'Connection Closed abnormally..!',
        qos: 0,
        retain: false
    },
    rejectUnauthorized: false
}

/** Connect to MQTT */
const client = mqtt.connect(host, options);

/**
 *  Error handling
 */
client.on('error', (err) => {
    console.log(err)
    client.end()
});

/**
 *  Connect to MQTT over WSS
 */
client.on('connect', () => {
    /**
     *  When subscribed, connect user to it's own topic
     */
    mainTopic = $('meta[name="mqtt-token"]').attr('content');
    // console.log("User token: " + mainTopic);

    /** Subscribe to token topic */
    client.subscribe(mainTopic, { qos: 0 })
});

client.on('message', (topic, message, packet) => {
    message = JSON.parse(message.toString());

    if(message['code'] === '0000'){
        /** Success message */
        if(message['type'] === 'system-access'){
            SystemAccess.parseMessage(message);
        }
    }else{
        /** Invalid message; Skip al actions */
        console.log("Unknown or invalid message.");
    }
    // console.log(message)
});

/**
 *  When socket is closed
 */
client.on('close', () => {

});
