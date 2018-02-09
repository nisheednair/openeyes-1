<?php
/**
 * OpenEyes
 *
 * (C) OpenEyes Foundation, 2017
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2017, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
?>

<?php

$model_name = CHtml::modelName($element);
$route_options = CHtml::listData($element->getRouteOptions(), 'id', 'name');
$frequency_options = CHtml::listData($element->getFrequencyOptions(), 'id', 'name');
$stop_reason_options = CHtml::listData($element->getStopReasonOptions(), 'id', 'name');
$element_errors = $element->getErrors();
?>
<script type="text/javascript" src="<?= $this->getJsPublishedPath('HistoryRisks.js') ?>"></script>
<script type="text/javascript" src="<?= $this->getJsPublishedPath('HistoryMedications.js') ?>"></script>
<div class="element-fields flex-layout full-width" id="<?= $model_name ?>_element">

    <input type="hidden" name="<?= $model_name ?>[present]" value="1" />
    <table id="<?= $model_name ?>_entry_table" <?php echo $element_errors ? 'class="highlighted-error"' : '' ?>>
        <thead class="row" style= <?php echo !sizeof($element->entries)?  'display:none': ''; ?> >
        <tr>
            <th >
              <button class="button small show-stopped" type="button">show stopped</button>
              <button class="button small hide-stopped" type="button" style="display: none;">Hide stopped</button>
            </th>
            <th></th>
            <th>Start</th>
            <th>Stopped(Optional)</th>
            <th>Reason</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $row_count = 0;
        foreach ($element->entries as $entry) {
            if ($entry->prescription_item_id) {
                $this->render(
                    'HistoryMedicationsEntry_prescription_event_edit',
                    array(
                        'entry' => $entry,
                        'form' => $form,
                        'model_name' => $model_name,
                        'field_prefix' => $model_name . '[entries][' . $row_count . ']',
                        'row_count' => $row_count,
                        'stop_reason_options' => $stop_reason_options
                    )
                );
            } else {
                $this->render(
                    'HistoryMedicationsEntry_event_edit',
                    array(
                        'entry' => $entry,
                        'form' => $form,
                        'model_name' => $model_name,
                        'field_prefix' => $model_name . '[entries][' . $row_count . ']',
                        'row_count' => $row_count,
                        'removable' => true,
                        'route_options' => $route_options,
                        'frequency_options' => $frequency_options,
                        'stop_reason_options' => $stop_reason_options
                    )
                );
            }
            $row_count++;
        }
        ?>
        </tbody>
    </table>
  <div class="flex-item-bottom" id="medication-history-popup">
    <button class="button hint green js-add-select-search" type="button">
      <i class="oe-i plus pro-theme"></i>
    </button>
  </div>

    <script type="text/template" class="entry-template hidden">
        <?php
        $empty_entry = new \OEModule\OphCiExamination\models\HistoryMedicationsEntry();
        $this->render(
            'HistoryMedicationsEntry_event_edit',
            array(
                'entry' => $empty_entry,
                'form' => $form,
                'model_name' => $model_name,
                'field_prefix' => $model_name . '[entries][{{row_count}}]',
                'row_count' => '{{row_count}}',
                'removable' => true,
                'route_options' => $route_options,
                'frequency_options' => $frequency_options,
                'stop_reason_options' => $stop_reason_options
            )
        );
        ?>
    </script>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    new OpenEyes.OphCiExamination.HistoryMedicationsController({
      element: $('#<?=$model_name?>_element')
    });

  });
</script>