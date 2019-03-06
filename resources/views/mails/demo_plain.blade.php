<html>
	<head>
	<head>
	<body>
		<div style='background-color:#FFF; width:100%; min-height:70px; border-bottom: 2px solid #25AAE1;'>
			<img src="{{ asset('public/images/logo.png')" width='150' style='margin-top:10px;margin-left:10px; float:left;'>
		</div>
		<div style='color:#586261; width:100%; font-size:16px; padding-top:10px;'>
			<div style='font-size:16px; font-weight:300; padding-left:10px; '>
				<div>{{ __('messages.email_msg_reg_2') }} {{ $demo->fname }}!</div><br/>
				<div>{{ __('messages.lbl_dear') {{ $demo->fname }},</div><br/>
				<div>{{ __('messages.email_msg_reg_1') }} <a href='https://findbo.dk/'>findbo.dk</a>. <br/>
					{{ __('messages.email_msg_reg_4') }} <br/>
					{{ __('messages.email_msg_reg_5') }}:<br/>
				<a href="{{ $demo->reset_link }}">Click here to activate....</a>
				</div><br/>
			</div>
		</div>
		<div style='color:#586261; font-size:16px; font-weight:300; padding-left:10px; '>
			<div>{{ __('messages.yours_sincerely') }}</div>
			<div>Findbo.dk</div>
		</div>
	</body>
</html>
        
        


