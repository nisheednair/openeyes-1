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
if (!Yii::app()->user->checkAccess('Super schedule operation') && Yii::app()->params['future_scheduling_limit'] && $date > date('Y-m-d', strtotime('+' . Yii::app()->params['future_scheduling_limit']))) { ?>
    <div class="alert-box alert with-icon" style="margin-top: 10px;">
        This date is outside the allowed booking window of <?php echo Yii::app()->params['future_scheduling_limit'] ?>
        and so cannot be booked into.
    </div>
<?php } ?>
<header class="element-header">
    <h3 class="element-title">Select theatre time</h3>
</header>
<div class="element-actions">
    <span class="js-remove-element">
	    <i class="oe-i remove-circle"></i>
	</span>
</div>

<div class="element-fields full-width">
    <div class="cols-full theatre-sessions">
        <table class="theatre-bookings">
            <tfoot>
            <?php $i = 0;
            foreach ($theatres as $i => $theatre) { ?>
                <tr>
                    <td>
                        <h3 style="float: left"><?php echo $theatre->name ?>
                            <?php if ($theatre->site) {
                                echo ' (' . $theatre->site->name . ')';
                            } ?>
                        </h3>
                    </td>
                </tr>
                <?php foreach ($theatre->sessions as $j => $session) { ?>
                    <tr>
                        <td class="<?php echo $session->id == @$selectedSession->id ? 'selected_session' : $session->status ?><?php if (strtotime(date('Y-m-d')) > strtotime($session->date)) {
                            echo ' inthepast';
                        } elseif ($session->operationBookable($operation)) {
                            echo ' bookable';
                        } ?>" id="bookingSession<?php echo $session->id ?>">
                            <div class="session_timeleft time-left available">
                                <?php echo abs($session->availableMinutes) ?> min
                                <?php echo $session->minuteStatus ?>
                            </div>
                            <div class="specialists">
                                <?php if ($session->consultant) { ?>
                                    <div class="consultant" title="Consultant Present">Consultant</div>
                                <?php } ?>
                                <?php if ($session->anaesthetist) { ?>
                                    <div class="anaesthetist" title="Anaesthetist Present">Anaesthetist
                                        <?php if ($session->general_anaesthetic) { ?>
                                            (GA)
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if ($session->paediatric) { ?>
                                    <div class="paediatric" title="Paediatric Session">Paediatric</div>
                                <?php } ?>
                            </div>
                        </td>
                        <?php if ($session->id != @$selectedSession->id) { ?>
                            <td>
                                <a href="<?php echo
                                    Yii::app()->createUrl('/' . $operation->event->eventType->class_name . '/booking/' . ($operation->booking ? 're' : '')
                                        . 'schedule/' . $operation->event_id) . '?' .
                                    implode('&', array(
                                        'firm_id=' . ($firm->id ? $firm->id : 'EMG'),
                                        'date=' . date('Ym', strtotime($date)),
                                        'day=' . CHtml::encode($_GET['day']),
                                        'session_id=' . $session->id,
                                        'referral_id=' . $operation->referral_id,)); ?>">
                                    <button class="large blue hint">Select time</button>
                                </a>
                            </td>
                        <?php } ?>
                    </tr>
                    <?php if (isset($selectedSession) && !$selectedSession->operationBookable($operation)) { ?>
                        <tr>
                            <td style="float:left">
                                <span class="session-unavailable">
                                    <?=\CHtml::encode($selectedSession->unbookableReason($operation)) ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php ++$i;
            } ?>
            </tfoot>
        </table>
        <?php if ($i == 0) {?>
            <h5>Sorry, this firm has no sessions on the selected day.</h5>
        <?php }?>
    </div>
</div>
