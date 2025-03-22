<?php

namespace App\Http\Controllers\Admin\Other\Analysis;

use App\Http\Controllers\Controller;
use App\Models\Other\Analysis\AEAnswer;
use App\Models\Other\Analysis\Analysis;
use App\Models\Trainings\Evaluations\Evaluation;
use App\Models\Trainings\Evaluations\EvaluationOption;
use App\Traits\Common\CommonTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller{
    use CommonTrait;
    protected string $_path = 'files/questionnaires/reports/';

    protected array $style = array(
        'borders' => array(
            'outline' => array(
                'borderStyle' => Border::BORDER_THICK,
                'color' => array('argb' => 'FDB833'),
            ),
        ),
        'fill' => array(
            'fillType' => Fill::FILL_SOLID,
            'startColor' => array('argb' => 'FDB833')
        ),
        'font' => [
            'color' => [
                'argb' => 'FFFFFF', // Blue: FF (alpha) + 0000FF (blue)
            ],
        ],
    );

    /**
     * Generate report and download excel file
     *
     * @param $analysis_id
     * @return RedirectResponse | BinaryFileResponse
     */
    public function getReport($analysis_id): RedirectResponse | BinaryFileResponse{
        try{
            /** Get analysis */
            $analysis = Analysis::where('id', '=', $analysis_id)->first();
            /** Get evaluation */
            $evaluation = Evaluation::where('type', '=','__analysis')->where('model_id', '=', $analysis->id)->first();

            $reader             = new Xlsx();
            $spreadsheet        = $reader->load(storage_path('files/questionnaires/report.xlsx'));
            $sheet              = $spreadsheet->getSheet(0);
            $secondSheet        = $spreadsheet->getSheet(1);

            /** Set name and date */
            $sheet->setCellValue('A4', $analysis->title);
            $sheet->setCellValue('I4', $this->onlyDate(date('Y-m-d')));

            $secondSheet->setCellValue('A4', $analysis->title);
            $secondSheet->setCellValue('I4', $this->onlyDate(date('Y-m-d')));

            $options = EvaluationOption::where('evaluation_id', '=', $evaluation->id)->where('type', '=', 'with_answers')->orderBy('group_by')->get();
            $row = 9;

            foreach($options as $option){
                /** Set style for question */
                $sheet->mergeCells("A".$row.":J".($row+1));
                $sheet->getStyle("A".$row.":J".($row+1))->getAlignment()->setHorizontal('left')->setVertical('center')->setWrapText(true);
                $sheet->getStyle("A".$row.":J".($row+1))->applyFromArray($this->style);
                /** Set value for question */
                $sheet->setCellValue('A' . $row, $option->question);

                $row += 2;
                $answers = AEAnswer::whereHas('analysisEvaluationRel', function($query){
                        $query->where('status', '=', 'submitted');
                    })->where('evaluation_id', '=', $evaluation->id)->where('option_id', '=', $option->id)->get();

                $counter = 1;
                $average = 0;
                foreach ($answers as $answer){
                    if($answer->answer != 0){
                        $sheet->getStyle("A".$row)->getAlignment()->setHorizontal('center')->setVertical('center');
                        $sheet->setCellValue('A' . $row, $counter . '.');

                        /** User info */
                        $sheet->mergeCells("B".$row.":H".$row);
                        $sheet->getStyle("B".$row.":H".$row)->getAlignment()->setHorizontal('left')->setVertical('center');
                        $sheet->setCellValue('B' . $row, $answer->analysisEvaluationRel->userRel->name ?? 'Anonimno');

                        $sheet->mergeCells("I".$row.":J".$row);
                        $sheet->getStyle("I".$row.":J".$row)->getAlignment()->setHorizontal('center')->setVertical('center');
                        $sheet->setCellValue('I' . $row, $answer->answer ?? '0');

                        $row ++;
                        $counter++;

                        $average += $answer->answer;
                    }
                }

                if($answers->count() > 0){
                    $sheet->mergeCells("I".$row.":J".$row);
                    $sheet->getStyle("I".$row.":J".$row)->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
                    $sheet->getStyle("I".$row.":J".$row)->getFont()->setBold(true);
                    $sheet->setCellValue('I' . $row,  $this->roundNumber($average / $counter, "2"));
                    $row++;
                }

                $row += 2;
            }

            /**
             *  Fill second sheet
             */
            $otherOptions = EvaluationOption::where('evaluation_id', '=', $evaluation->id)->where('type', '=', 'question_only')->orderBy('group_by')->get();
            $row = 9;

            foreach($otherOptions as $option){
                /** Set style for question */
                $secondSheet->mergeCells("A".$row.":J".($row+1));
                $secondSheet->getStyle("A".$row.":J".($row+1))->getAlignment()->setHorizontal('left')->setVertical('center')->setWrapText(true);
                $secondSheet->getStyle("A".$row.":J".($row+1))->applyFromArray($this->style);
                /** Set value for question */
                $secondSheet->setCellValue('A' . $row, $option->question);

                $row += 2;
                $answers = AEAnswer::whereHas('analysisEvaluationRel', function($query){
                    $query->where('status', '=', 'submitted');
                })->where('evaluation_id', '=', $evaluation->id)->where('option_id', '=', $option->id)->get();

                $counter = 1;
                foreach ($answers as $answer){
                    if($answer->answer != ''){
                        $secondSheet->getStyle("A".$row)->getAlignment()->setHorizontal('center')->setVertical('center');
                        $secondSheet->setCellValue('A' . $row, $counter . '.');

                        /** User info */
                        $secondSheet->mergeCells("B".$row.":D".$row);
                        $secondSheet->getStyle("B".$row.":D".$row)->getAlignment()->setHorizontal('left')->setVertical('center');
                        $secondSheet->setCellValue('B' . $row, $answer->analysisEvaluationRel->userRel->name ?? 'Anonimno');

                        $secondSheet->mergeCells("E".$row.":J".$row);
                        $secondSheet->getStyle("E".$row.":J".$row)->getAlignment()->setHorizontal('left')->setVertical('center');
                        $secondSheet->setCellValue('E' . $row, $answer->answer ?? '0');

                        $row ++;
                        $counter++;
                    }
                }

                $row += 2;
            }

            $fileName = ($this->generateSlug($analysis->title . date('d-m-y'))) . '.xlsx';
            $writer = new  \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save(storage_path($this->_path) . $fileName);

            return response()->download(storage_path($this->_path . $fileName));
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
