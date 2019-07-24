@if(session('message'))
	@if(session('message')['code'] == 200)
		<div class="am-alert am-alert-success" data-am-alert>
		                  <button type="button" class="am-close">&times;</button>
		                  <p>{{ session('message')['data'] }}</p>
		</div>
	@elseif(session('message')['code'] == 500)
		<div class="am-alert am-alert-danger" data-am-alert>
		                  <button type="button" class="am-close">&times;</button>
		                  <p>{{ session('message')['data'] }}</p>
		</div>
	@endif
@endif

@if (count($errors) > 0)
    	<div class="am-alert am-alert-danger" data-am-alert>
		                  <button type="button" class="am-close">&times;</button>
		                    @foreach ($errors->all() as $error)
				                <p>{{ $error }}</p>
				            @endforeach
		</div>
@endif

<div class="am-alert am-alert-danger message" data-am-alert style="display:none">
              <button type="button" class="am-close">&times;</button>
              <p></p>
</div>