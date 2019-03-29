<h2>
	@lang('messages.register_thanks_head')
</h2>
<p>
	@lang('messages.register_thanks_body')
	<br/>
	<a href="{{ route('activate', $code) }}">
		@lang('messages.lbl_activate')
	</a>
</p>
<p style="margin-top: 100px">Findbo Team</p>