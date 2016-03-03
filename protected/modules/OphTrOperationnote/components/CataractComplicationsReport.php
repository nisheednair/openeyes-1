<?php

/**
 * Created by PhpStorm.
 * User: peter
 * Date: 19/02/16
 * Time: 16:39
 */
class CataractComplicationsReport extends Report implements ReportInterface
{
    /**
     * @var array
     */
    protected $graphConfig = array(
        'chart' => array('renderTo' => '', 'type' => 'bar'),
        'legend' => array('enabled' => false),
        'title' => array('text' => 'Case Complexity Adjusted PCR Rate'),
        'subtitle' => array('text' => 'Total Complications: '),
        'xAxis' => array(
            'categories' => array(),
            'title' => array('text' => 'Complication'),
            'labels' => array('style' => array('fontSize' => '0.5em'))
        ),
        'tooltip' => array(
            'headerFormat' => '<b>Cataract Complications</b><br>',
            'pointFormat' => '<i>Complication</i>: {point.category} <br /> <i>Percentage </i>: {point.y}'
        )
    );

    /**
     * @param $surgeon
     * @param $dateFrom
     * @param $dateTo
     * @return array|CDbDataReader
     */
    protected function queryData($surgeon, $dateFrom, $dateTo)
    {
        $this->command->reset();
        $this->command->select('COUNT(cataract_id) as complication_count, ophtroperationnote_cataract_complications.name')
            ->from('ophtroperationnote_cataract_complication')
            ->join('et_ophtroperationnote_cataract', 'ophtroperationnote_cataract_complication.cataract_id = et_ophtroperationnote_cataract.id')
            ->join('event', 'et_ophtroperationnote_cataract.event_id = event.id')
            ->join('et_ophtroperationnote_surgeon', 'et_ophtroperationnote_surgeon.event_id = event.id')
            ->join('ophtroperationnote_cataract_complications',
                'ophtroperationnote_cataract_complication.complication_id = ophtroperationnote_cataract_complications.id'
            )
            ->where('surgeon_id = :surgeon', array('surgeon' => $surgeon))
            ->group('complication_id');

        if ($dateFrom) {
            $this->command->andWhere('event.event_date > :dateFrom', array('dateFrom' => $dateFrom));
        }

        if ($dateTo) {
            $this->command->andWhere('event.event_date < :dateTo', array('dateTo' => $dateTo));
        }

        return $this->command->queryAll();
    }

    /**
     * @return array
     */
    public function dataSet()
    {
        $data = $this->queryData($this->surgeon, $this->from, $this->to);
        $seriesCount = array();
        $this->setComplicationCategories();
        $total = $this->getTotalComplications();

        foreach ($this->graphConfig['xAxis']['categories'] as $category) {
            foreach ($data as $complicationData) {
                if ($category === $complicationData['name']) {
                    $seriesCount[] = ($complicationData['complication_count'] / $total ) * 100;
                    continue 2;
                }
            }
            $seriesCount[] = 0;
        }

        return $seriesCount;
    }

    /**
     * @return string
     */
    public function seriesJson()
    {
        $this->series = array(
            array(
                'name' => 'Complications',
                'data' => $this->dataSet(),
            )
        );

        return json_encode($this->series);
    }

    /**
     * @return string
     */
    public function graphConfig()
    {
        $this->setComplicationCategories();
        $this->graphConfig['chart']['renderTo'] = $this->graphId();
        $this->graphConfig['subtitle']['text'] .= $this->getTotalComplications();

        return json_encode(array_merge_recursive($this->globalGraphConfig, $this->graphConfig));
    }

    /**
     * @return array|CDbDataReader
     */
    protected function allComplications()
    {
        $this->command->reset();

        return $this->command->select('name')
            ->from('ophtroperationnote_cataract_complications')
            ->queryAll();
    }

    /**
     *
     */
    protected function setComplicationCategories()
    {
        if (!$this->graphConfig['xAxis']['categories']) {
            $complications = $this->allComplications();
            foreach ($complications as $complication) {
                $this->graphConfig['xAxis']['categories'][] = $complication['name'];
            }
        }

    }

    protected function getTotalComplications()
    {
        $data = $this->queryData($this->surgeon, $this->from, $this->to);
        $total = 0;
        foreach($data as $complication){
            $total += $complication['complication_count'];
        }

        return $total;
    }
}