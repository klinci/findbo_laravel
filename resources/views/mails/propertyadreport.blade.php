<html>
	<head>
	<head>
	<body>
		<div style='background-color:#FFF; width:100%; min-height:70px; border-bottom: 2px solid #25AAE1;'>
			<img src="{{ asset('public/images/logo.png') }}" width='150' style='margin-top:10px;margin-left:10px; float:left;'>
		</div>
		<div style='font-size:16px;font-weight:300;padding-left:10px;'>
			<div>Property Status Report for property</div>
			<div><a target='_blank' href="{{ $property_link }}">{{ $property_link }}</a></div>
			<br/>
			<table>
				<tbody>
					<tr><td width='115px'>Email ID : </td><td>{{ $reporter_email }}</td></tr>
					<tr><td>Name : </td><td>{{ $reporter_name }}</td></tr>
					<tr><td>Reason : </td><td>{{ $reporter_reason }}</td></tr>
					<tr><td style='vertical-align:top;'>Reason Desc. :</td><td>{{ $reporter_reason_desc }}</td></tr>
				</tbody>
			</table>
			<br/>
		</div>
		<div style='color:#586261; font-size:16px; font-weight:300; padding-left:10px; '>
			<div>{{ __('messages.yours_sincerely') }}</div>
			<div>Findbo.dk</div>
		</div>
	</body>
</html>
        
        


