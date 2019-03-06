<html>
	<head>
	<head>
	<body>
		<div style='background-color:#FFF; width:100%; min-height:70px; border-bottom: 2px solid #25AAE1;'>
			<img src="{{ asset('public/images/logo.png') }}" width='150' style='margin-top:10px;margin-left:10px; float:left;'>
		</div>
		<div style='font-size:16px; font-weight:300; padding-left:10px; '>
			<div>{{ __('messages.lbl_dear') }} {{ $receiver_fname }},</div><br/>
			<div>{{ __('messages.email_msg_seek_info_2') }} {{ $sender_fname }}.</div><br/>
			<div>{{ __('messages.email_msg_seek_info_3') }} :<br/>
			<a href="{{ url('message_inbox') }}">{{ url('message_inbox') }}</a>
			</div><br/>
		</div>
		<div style='color:#586261; font-size:16px; font-weight:300; padding-left:10px; '>
			<div>{{ __('messages.yours_sincerely') }}</div>
			<div>Findbo.dk</div>
		</div>
	</body>
</html>
        
        


