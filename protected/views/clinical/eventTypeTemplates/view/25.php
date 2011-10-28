<?php
/*
_____________________________________________________________________________
(C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
(C) OpenEyes Foundation, 2011
This file is part of OpenEyes.
OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
_____________________________________________________________________________
http://www.openeyes.org.uk	 info@openeyes.org.uk
--
*/

foreach ($elements as $element) {
	if (get_class($element) == 'ElementOperation') {
		$operation = $element;
		break;
	}
}

?>
<!-- Details -->
<h3>Operation (<?php echo $operation->getStatusText()?>)</h3>
<h4>Diagnosis</h4>

<div class="eventHighlight">
	<?php $disorder = $operation->getDisorder(); ?>
	<h4><?php echo !empty($disorder) ? $operation->getEyeText() : 'Unknown' ?> <?php echo !empty($disorder) ? $operation->getDisorder() : '' ?></h4>
</div>

<h4>Operation</h4>
<div class="eventHighlight">
	<h4><?php
foreach ($elements as $element) {
	// Only display elements that have been completed, i.e. they have an event id
	if ($element->event_id) {
		$viewNumber = $element->viewNumber;

		if (get_class($element) == 'ElementOperation') {
			foreach ($element->procedures as $procedure) {
				echo "{$procedure->short_format} ({$procedure->default_duration} minutes)<br />";
			}
		}
	}
}
?></h4>
</div>

<?php

if (!empty($operation->booking)) {
?>
<h4>Session</h4>
<div class="eventHighlight">
<?php $session = $operation->booking->session ?>
<h4><?php
	if (empty($session->sequence->sequenceFirmAssignment)) {
		$firmName = 'Emergency List';
	} else {
		$firmName = $session->sequence->sequenceFirmAssignment->firm->name . ' (' .
					$session->sequence->sequenceFirmAssignment->firm->serviceSpecialtyAssignment->specialty->name . ')';
	}

	echo $session->start_time . ' - ' .
		$session->end_time . ' ' .
		date('jS F, Y', strtotime($session->date)) . ', ' . $firmName
?></h4>
</div>
<?php
}
?>

<?php if ($operation->status != $operation::STATUS_CANCELLED && $editable) {
?>
<!-- editable -->
<?php
	if (empty($operation->booking)) {
		$isAdmissionLetter = true;

		// The operation hasn't been booked yet?>
		<div style="margin-top:40px; text-align:center;">
			<button type="submit" value="submit" class="wBtn_print-invitation-letter ir" id="btn_print-invitation-letter">Print invitation letter</button>
			<button type="submit" value="submit" class="wBtn_print-reminder-letter ir" id="btn_print-reminder-letter">Print reminder letter</button>
			<button type="submit" value="submit" class="wBtn_print-gp-refer-back-letter ir" id="btn_print-gp-refer-back-letter">Print GP refer back letter</button>
			<button type="submit" value="submit" class="wBtn_schedule-now ir" id="btn_schedule-now">Schedule now</button>
			<button type="submit" value="submit" class="wBtn_cancel-operation ir" id="btn_cancel-operation">Cancel operation</button>
		</div>
	<?php } else {?>
		<div style="margin-top:40px; text-align:center;">
			<button type="submit" value="submit" class="btn_print-letter ir" id="btn_print-letter">Print letter</button>
			<button type="submit" value="submit" class="wBtn_reschedule-now ir" id="btn_reschedule-now">Reschedule now</button>
			<button type="submit" value="submit" class="wBtn_reschedule-later ir" id="btn_reschedule-later">Reschedule later</button>
			<button type="submit" value="submit" class="wBtn_cancel-operation ir" id="btn_cancel-operation">Cancel operation</button>
		</div>
	<?php }?>
<?php }?>






<!-- ================================================ -->
  <!-- * * * * * * * * * *  LETTER  * * * * * * * * * * -->
  <!-- ================================================ -->

  <div id="letters">
  	<div id="letterTemplate">
  		<div id="l_type">Type of Letter</div>
  		<div id="l_address">

  			<table width="100%">
  				<tr>
  					<td style="text-align:left;" width="50%"><img src="/img/_print/letterhead_seal.jpg" alt="letterhead_seal" /></td>
  					<td style="text-align:right;"><img src="/img/_print/letterhead_Moorfields_NHS.jpg" alt="letterhead_Moorfields_NHS" /></td>
  				</tr>
  				<tr>
  					<td colspan="2" style="text-align:right;">
					LocationFullName<br />

					LocationAddress1<br />
					LocationAddress2<br />
					LocationAddress3<br />
					LocationAddress4<br />
					</td>
  				</tr>
  				<tr>

  					<td style="text-align:left;">
					Parent/Guardian of PatientName<br />
					PatientAddress1<br />
					PatientAddress2<br />
					PatientCity<br />
					PatientPostCode<br />

					PatientCountry<br />
					</td>
					<td style="text-align:right;">
					&nbsp;<br />
					Tel LocationTel<br />
					Fax LocationFax<br />
					</td>

  				</tr>
  				<tr>
  					<td colspan="2" style="text-align:right;">
					LetterDate
					</td>
  				</tr>
  			</table>
  		</div>
  		<div id="l_content">

<p><strong>Hospital number reference: INP/A/Hosnum<br />
NHS number:</strong></p>

<p>Dear Parent or Guardian of PatientName,</p>

<p>I have been asked to arrange your child's admission for surgery under the care of CONSULTANT. This is currently anticipated to be a<ADMIT TYPE> procedure STAYLENGTH in hospital.</p>

<p>Please will you telephone CONTACT within TIME LIMIT of the date of this letter to discuss and agree a convenient date for this operation. If there is no reply, please leave a message and contact number on the answer phone.</p>

<p>Should your child no longer require treatment, please let me know as soon as possible.</p>


<p>Yours sincerely,
<br />
<br />
<br />
<br />
<br />
Admissions Officer</p>
  		</div>


  	</div> <!-- #letterTemplate -->
  </div> <!-- #letters -->


<div id="letterFooter">   <!--  letter footer -->
Patron: Her Majesty The Queen<br />
Chairman: Rudy Markham<br />
Chief Executive: John Pelly<br />
</div>

  <!-- ================================================ -->
  <!-- * * * * * * * * end of LETTER  * * * * * * * * * -->
  <!-- ================================================ -->


  <!-- ================================================ -->

  <!-- * * * * * * * * *    FORM    * * * * * * * * * * -->
  <!-- ================================================ -->

<div id="printForm">
  	<div id="printFormTemplate">
		<table width="100%">
			<tr>
				<td colspan="2" style="border:none;">&nbsp;</td>
				<td colspan="4" style="text-align:right; border:none;"><img src="/img/_print/letterhead_Moorfields_NHS.jpg" alt="letterhead_Moorfields_NHS" /></td>
			</tr>

			<tr>
				<td colspan="2" width="50%"> <!-- width control -->
					<span class="title">Admission Form</span>
				</td>
				<td rowspan="4">
					Patient Name,<br />
					Address<br />

					Address<br />
				</td>
				<td rowspan="4">
					Patient Name,<br />
					Address 1<br />
					Address 1<br />
				</td>

			</tr>
			<tr>
				<td>Hospital Number</td>
				<td>number</td>
			</tr>
			<tr>
				<td>DOB</td>

				<td>dd/mm/yyyy</td>
			</tr>
			<tr>
				<td>[empty]</td>
				<td>[empty]</td>
			</tr>
		</table>


		<table width="100%">
			<tr>
				<td width="25%"><strong>Admitting Consultant:</strong></td> <!-- width control -->
				<td width="25%">Consultant</td>
				<td><strong>Decision to admit date (or today�s date):</strong></td>
				<td>AdminDate</td>

			</tr>
			<tr>
				<td>Service:</td>
				<td>Service</td>
				<td>Telephone:</td>
				<td>Telephone</td>
			</tr>
			<tr>
				<td>Site:</td>
				<td>site</td>
				<td colspan="2">

					<table width="100%" class="subTableNoBorders">
						<tr>
							<td>AlternatePhone</td>
							<td>WorkPhone</td>
							<td>MobilePhone</td>
						</tr>
					</table>

				</td>
			</tr>
			<tr>
				<td><strong>Person organising admission:</strong></td>
				<td>Doctor</td>
				<td><strong>Dates patient unavailable:</strong></td>
				<td>DatesCantComeIn</td>
			</tr>
			<tr>

				<td colspan="2" style="border-bottom:1px dotted #000;">Signature:</td>
				<td>Available at short notice:</td>
				<td>ShortNotice</td>
			</tr>
		</table>
		<span class="subTitle">ADMISSION DETAILS</span>
		<table width="100%">
			<tr>

				<td width="25%"><strong>Urgency:</strong></td> <!-- width control -->
				<td width="25%">Urgency</td>
				<td><strong>Consultant to be present:</strong></td>
				<td>Cons</td>
			</tr>
			<tr>

				<td>Admission category:</td>
				<td>DayCase</td>
				<td colspan="2" rowspan="5" align="center" style="vertical-align:middle;">
					<strong>Patient Added to Waiting List.<br />
					Admission Date to be arranged</strong>
				</td>

			</tr>
			<tr>

				<td><strong>Diagnosis:</strong></td>
				<td>Diagnosis</td>

			</tr>
			<tr>
				<td><strong>Intended procedure:</strong></td>
				<td>Operation</td>

			</tr>
			<tr>
				<td><strong>Eye:</strong></td>
				<td>eye</td>
			</tr>

			<tr>
				<td><strong>Total theatre time (mins):</strong></td>
				<td>duration</td>
			</tr>
		</table>
		<span class="subTitle">PRE-OP ASSESSMENT INFORMATION</span>
		<table width="100%">
			<tr>

				<td width="25%"><strong>Anaesthesia:</strong></td> <!-- width control -->
				<td width="25%">anaesth</td>
				<td><strong>Likely to need anaesthetist review:</strong></td>
				<td>anaes</td>
			</tr>
			<tr>

				<td><strong>Anaesthesia is:</strong></td>
				<td>anaesth</td>
				<td><strong>Does the patient need to stop medication:</strong></td>
				<td>stopMed</td>
			</tr>
		</table>
		<span class="subTitle">COMMENTS</span>

		<table width="100%">
			<tr>
				<td style="border:2px solid #666; height:7em;">Comments</td>
			</tr>

		</table>

  	</div> <!-- adminFormTemplate -->
 </div> <!-- printForm -->


  <!-- ================================================ -->

  <!-- * * * * * * * *  end of FORM   * * * * * * * * * -->
  <!-- ================================================ -->





<script type="text/javascript">
	$('#btn_schedule-now').unbind('click').click(function() {
		$.ajax({
			url: '/booking/schedule',
			type: "GET",
			data: {'operation': <?php echo $operation->id?>},
			success: function(data) {
				$('#event_content').html(data);
				return false;
			}
		});
	});
	$('#btn_cancel-operation').unbind('click').click(function() {
		$.ajax({
			url: '/booking/cancelOperation',
			type: "GET",
			data: {'operation': <?php echo $operation->id?>},
			success: function(data) {
				$('#event_content').html(data);
				return false;
			}
		});
	});
	$('#btn_reschedule-now').unbind('click').click(function() {
		$.ajax({
			url: '/booking/reschedule',
			type: "GET",
			data: {'operation': <?php echo $operation->id?>},
			success: function(data) {
				$('#event_content').html(data);
				return false;
			}
		});
	});
	$('#btn_reschedule-later').unbind('click').click(function() {
		$.ajax({
			url: '/booking/rescheduleLater',
			type: "GET",
			data: {'operation': <?php echo $operation->id?>},
			success: function(data) {
				$('#event_content').html(data);
				return false;
			}
		});
	});
	$('#btn_print-invitation-letter').unbind('click').click(function() {
		printContent('Some test letter content');
	});
</script>
