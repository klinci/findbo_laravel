<html>
	<head>
	<head>
	<body>
		<div style='background-color:#FFF; width:100%; min-height:70px; border-bottom: 2px solid #25AAE1;'>
			<img src="{{ asset('public/images/logo.png') }}" width='150' style='margin-top:10px;margin-left:10px; float:left;'>
		</div>
		<div style='color:#586261; width:100%; font-size:16px; padding-top:10px;'>
			<div style='font-size:16px; font-weight:300; padding-left:10px; '>
				<div>{{ __('messages.email_msg_seeker_pk_1') }} {{ $description }}  {{ __('messages.lbl_to') }} {{ floatval($amount/100) }} Kr. for {{ $days }} {{ strtolower(__('messages.lbl_days')) }}</div><br/>
	            <div>{{ __('messages.email_msg_seeker_pk_2') }} {{ $days }} {{ strtolower(__('messages.lbl_days')) }}</div><br/>
	            <div>{{ __('messages.email_msg_seeker_pk_3') }} : {{ $balance_transaction }}</div><br/>
	            <div>{{ __('messages.email_msg_seeker_pk_4') }} </div><br/>
			</div>
		</div>
		<div style='color:#586261; font-size:16px; font-weight:300; padding-left:10px; '>
			<div>{{ __('messages.yours_sincerely') }}</div>
			<div>Findbo.dk</div>
		</div>
	</body>
</html>
        
        


