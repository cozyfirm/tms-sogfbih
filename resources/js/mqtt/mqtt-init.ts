export class MqttInit {
    static clientID: any = 'mqtt-js' + Math.random().toString(16);
    static host: string = 'wss://mqtt.cozyfirm.com';
    static port: string = '8083';

    static lastWill : any = {
        topic: 'kont/kont-channel',
        payload: 'Connection Closed abnormally. Time',
        qos: 0,
        retain: false
    }
    static options : any = {
        keepalive: 5,
        clientId: 'mqtt-js' + Math.random().toString(16),
        protocolId: 'MQTT',
        protocolVersion: 4,
        clean: true,
        reconnectPeriod: 1000,
        connectTimeout: 30 * 1000,
        will: this.lastWill
    }

    static getHost() : string {
        return this.host;
    }
    static getWssHost() : string {
        return this.host + ":" + this.port;
    }
}
