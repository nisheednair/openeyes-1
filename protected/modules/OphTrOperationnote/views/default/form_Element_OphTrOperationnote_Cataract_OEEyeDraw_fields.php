<?php
/**
 * OpenEyes.
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
?>
<div class="cols-full">
    <table class="cols-full last-left">
        <colgroup>
            <col class="cols-6">
        </colgroup>
        <tbody>
        <tr>
            <td>
                <?php echo $element->getAttributeLabel('incision_site_id'); ?>
            </td>
            <td>
                <?php echo $form->dropDownList($element, 'incision_site_id', 'OphTrOperationnote_IncisionSite',
                    array('empty' => '- Please select -', 'textAttribute' => 'data-value', 'nolabel' => true), false,
                    array('field' => 4)) ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $element->getAttributeLabel('length'); ?>
            </td>
            <td>
                <?php echo $form->textField($element, 'length', array('nowrapper' => true), array(),
                    array_merge($form->layoutColumns, array('field' => 3))) ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $element->getAttributeLabel('meridian'); ?>
            </td>
            <td>
                <?php echo $form->textField($element, 'meridian', array('nowrapper' => true), array(),
                    array_merge($form->layoutColumns, array('field' => 3))) ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $element->getAttributeLabel('incision_type_id'); ?>
            </td>
            <td>
                <?php echo $form->dropDownList($element, 'incision_type_id', 'OphTrOperationnote_IncisionType',
                    array('empty' => '- Please select -', 'textAttribute' => 'data-value', 'nolabel' => true), false,
                    array('field' => 4)) ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo $form->textArea($element, 'report', [], false, ['rows' => 6, 'readonly' => true]) ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo $form->textArea($element, 'comments', [], false, [ 'rows' => 1 ]) ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php echo $element->getAttributeLabel('iol_type_id'); ?>
            </td>
            <td>
                <?php
                if (isset(Yii::app()->modules["OphInBiometry"])): ?>
                    <?php echo $form->dropDownList($element, 'iol_type_id',
                        CHtml::listData(OphInBiometry_LensType_Lens::model()->findAll(array(
                            'condition' => ($element->iol_type_id > 0) ? 'active=1 or id=' . $element->iol_type_id : 'active=1',
                            'order' => 'display_name',
                        )), 'id', 'display_name'),
                        array('empty' => '- Please select -', 'nolabel' => true), $element->iol_hidden,
                        array('field' => 6)); ?>
                <?php else: ?>
                    <?php echo $form->dropDownList($element, 'iol_type_id', array(
                        CHtml::listData(OphTrOperationnote_IOLType::model()->activeOrPk($element->iol_type_id)->findAll(array(
                            'condition' => 'private=0',
                            'order' => 'display_order asc',
                        )), 'id', 'name'),
                        CHtml::listData(OphTrOperationnote_IOLType::model()->activeOrPk($element->iol_type_id)->findAll(array(
                            'condition' => 'private=1',
                            'order' => 'display_order',
                        )), 'id', 'name'),
                    ),
                        array('empty' => '- Please select -', 'divided' => true, 'nolabel' => true), $element->iol_hidden,
                        array('field' => 6)) ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr id="div_Element_OphTrOperationnote_Cataract_iol_power">
            <td>
                <label>IOL power</label>
            </td>
            <td>
                <input id="Element_OphTrOperationnote_Cataract_iol_power" type="text"
                       name="Element_OphTrOperationnote_Cataract[iol_power]" autocomplete="off"
                       value="<?php echo $element->iol_power; ?>">
            </td>
        </tr>
        <tr>
            <td class="flex-layout flex-left">
                <label for="Element_OphTrOperationnote_Cataract_predicted_refraction">Predicted refraction:</label>
            </td>
            <td>
                <input id="Element_OphTrOperationnote_Cataract_predicted_refraction" type="text"
                       name="Element_OphTrOperationnote_Cataract[predicted_refraction]" autocomplete="off"
                       value="<?php echo $element->predicted_refraction; ?>">
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $element->getAttributeLabel('iol_position_id'); ?>
            </td>
            <td>
                <?php echo $form->dropDownList($element, 'iol_position_id', 'OphTrOperationnote_IOLPosition',
                    array(
                        'empty' => '- Please select -',
                        'options' => array(
                            8 => array('disabled' => 'disabled'),
                        ),
                        'nolabel' => true,
                    ),
                    $element->iol_hidden, array('field' => 4)
                ) ?>
            </td>
        </tr>
        <tr>
            <td>Agents</td>
            <td>
                <?php echo $form->multiSelectList($element, 'OphTrOperationnote_CataractOperativeDevices',
                    'operative_devices',
                    'id',
                    $this->getOperativeDeviceList($element), $this->getOperativeDeviceDefaults(),
                    array('empty' => '- Agents -', 'label' => 'Agents', 'nowrapper' => true),
                    false, false, null, false, false,
                    array('field' => 4)) ?>
            </td>
        </tr>
        <tr>
            <td>
                Phaco CDE:
            </td>
            <td>
                <input autocomplete="off" type="text" name="Element_OphTrOperationnote_Cataract[phaco_cde]"
                       id="Element_OphTrOperationnote_Cataract_phaco_cde" value="<?php echo $element->phaco_cde ?>">
                <i class="oe-i info small pad js-has-tooltip "
                   data-tooltip-content="Cumulative Dissipated Energy, in 'seconds'"></i>
            </td>
        </tr>
        <tr>
            <td>Complications</td>
            <td>
                <?php echo $form->multiSelectList($element, 'OphTrOperationnote_CataractComplications', 'complications', 'id',
                    CHtml::listData(OphTrOperationnote_CataractComplications::model()->activeOrPk($element->cataractComplicationValues)->findAll(
                        array('order' => 'display_order asc')),
                        'id', 'name'),
                    null,
                    array('empty' => '- Complications -', 'label' => 'Complications', 'nowrapper' => true),
                    false, false, null,
                    false, false, array('field' => 4)) ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo $form->textArea($element, 'complication_notes', array('nowrapper' => true), false,
                    array(
                        'rows' => 6,
                        'cols' => 40,
                        'placeholder' => $element->getAttributeLabel('complication_notes'),
                    )) ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<?php echo $form->hiddenInput($element, 'pcr_risk') ?>
<script>
    $(document).ready(function () {
        $('#Element_OphTrOperationnote_Cataract_comments').autosize();
        $('#Element_OphTrOperationnote_Cataract_complication_notes').autosize();
    });
</script>
