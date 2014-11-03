<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="./public/css/pdf.css">
</head>
<body>
	<div class="online-form">
		<table id="form-header">
			<tr>
				<td class="left"><h1 class="form-title">{{ strtoupper($pageTitle) }}</h1></td>
				<td class="right"><img src="./public/img/bcd-logo.png" alt="Logo" style="width:148.5px; margin-top:10px;"></td>
			</tr>
			<tr>
				<td class="left"><h3 class="control-num"> No. {{ e($rfp->form_num) }} </h3></td>
			</tr>
		</table>
		<div id="form-general-div">
			<table id="form-general">
				<tr class="row-line">
					<td class="left"><label class="form-label">Payee</label>{{ e($rfp->payee_full_name) }}</td>
					<td class="right"><label class="form-label">Date</label>{{ e($rfp->date_requested) }}</td>
				</tr>
				<tr>
					<td class="left"><label class="form-label">Particulars</label>{{ e($rfp->particulars) }}</td>
					<td class="right"><label class="form-label">Amount</label>{{ e($rfp->total_amount_formatted) }}</td>
				</tr>
			</table>
		</div><!-- #form-header -->
		<div id="form-content-div">
			<table id="form-content">
				<tr>
					<td class="left">
						<table id="form-content-proper">
							<tr class="row-line-head">
								<td class="col"><label class="form-label">Charge to (Client/Project)</label>{{ e($rfp->client->client_name) }}</td>
								<td class="fake"></td>
								<td class="col"><label class="form-label">Requested by</label>{{ e($rfp->onlineForm->creator->full_name) }}</td>
							</tr>
							<tr class="row-line">
								<td class="col"><label class="form-label">CE No.</label>{{ e($rfp->check_num) }}</td>
								<td class="fake"></td>
								<td class="col"><label class="form-label">Department</label>{{ e($rfp->onlineForm->department->department_name) }}</td>
							</tr>
							<tr class="row-line">
								<td class="col"><label class="form-label">Date Needed</label> {{ e($rfp->date_needed) }} </td>
								<td class="fake"></td>
								<td class="col"><label class="form-label">Appoved by</label>{{ e($rfp->onlineForm->approved_by_formatted) }}</td>
							</tr>
							<tr>
								<td class="col"><label class="form-label">Received by</label>{{ e($rfp->onlineForm->received_by_formatted) }}</td>
							</tr>
						</table>
					</td>
					<td class="right">
						@include('layout.partials._bcd-ci')
					</td>
				</tr>
			</table>
		</div><!-- #form-content-div -->
	</div><!-- .online-form -->
</body>
</html>

