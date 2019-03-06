<html>
	<head>
	<head>
	<body>
		<div style='background-color:#FFF; width:100%; min-height:70px; border-bottom: 2px solid #25AAE1;'>
			<img src="{{ asset('public/images/logo.png') }}" width='150' style='margin-top:10px;margin-left:10px; float:left;'>
		</div>
		<div style='font-size:16px; font-weight:300; padding-left:10px; '>
			<p>Name : {{ $name }}</p>
			<p>{{ __('messages.lbl_reply') }} : {{ $email }}</p>
       		<p>{{ __('messages.subject') }} :  {{ $subject }}</p>
            <p>{{ $message_body }}</p>
        </div>
		<div style='color:#586261; font-size:16px; font-weight:300; padding-left:10px; '>
			<div>{{ __('messages.yours_sincerely') }}</div>
			<div>Findbo.dk</div>
		</div>
	</body>
</html>
        
        


