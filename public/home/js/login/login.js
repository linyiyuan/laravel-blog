$(function(){
	var tab = 'account_number';

	var api = '';//声明接口
	// 选项卡切换
	$(".account_number").click(function () {
		$('.tel-warn').addClass('hide');
		tab = $(this).attr('class').split(' ')[0];
		checkBtn();
        $(this).addClass("on");
        $(".message").removeClass("on");
        $(".form2").addClass("hide");
        $(".form1").removeClass("hide");
        $('.log-btn').text('登录');
    });
	// 选项卡切换
	$(".message").click(function () {
		$('.tel-warn').addClass('hide');
		tab = $(this).attr('class').split(' ')[0];
		checkBtn();
		$(this).addClass("on");
        $(".account_number").removeClass("on");
		$(".form2").removeClass("hide");
		$(".form1").addClass("hide");
		$('.log-btn').text('注册');
		
    });

	$('#num').keyup(function(event) {
		$('.tel-warn').addClass('hide');
		checkBtn();
	});

	$('#pass').keyup(function(event) {
		$('.tel-warn').addClass('hide');
		checkBtn();
	});

	$('#veri').keyup(function(event) {
		$('.tel-warn').addClass('hide');
		checkBtn();
	});

	$('#num2').keyup(function(event) {
		$('.tel-warn').addClass('hide');
		checkBtn();
	});

	$('#veri-code').keyup(function(event) {
		$('.tel-warn').addClass('hide');
		checkBtn();
	});


	//单击时候更换验证码
	$('.get-code').on('click',function(){
		getCode();
	});

	// 按钮是否可点击
	function checkBtn()
	{
		$(".log-btn").off('click');
		if (tab == 'account_number') {
			//如果是账号登录进来这里
			var inp = $.trim($('#num').val());
			var pass = $.trim($('#pass').val());
			if (!checkAccount(inp)) {
				//验证账号
				$(".log-btn").addClass("off");
				return false;
			}else if (!checkPass(pass)) {
				//验证手机
				$(".log-btn").addClass("off");
				return false;
			}
			if (inp != '' && pass != '') {
				$(".log-btn").removeClass("off");
				sendBtn();//调用登录方法
			} else {
				$(".log-btn").addClass("off");
			}
		} else {
			//如果是短信注册进来这里
			var phone = $.trim($('#num2').val());
			var code2 = $.trim($('#veri-code').val());
			if (phone != '' && code2 != '') {
				$(".log-btn").removeClass("off");
				sendBtn();
			} else {
				$(".log-btn").addClass("off");
			}
		}
	}

	function checkAccount(username){
		if (username == '') {
			$('.num-err').removeClass('hide').find("em").text('请输入账户');
			return false;
		} else {
			$('.num-err').addClass('hide');
			return true;
		}
	}

	function checkPass(pass){
		if (pass == '') {
			$('.pass-err').removeClass('hide').find("em").text('请输入密码');
			return false;
		} else {
			$('.pass-err').addClass('hide');
			return true;
		}
	}

	//检查验证码
	function checkCode(captcha){
		$.ajax({
            url: api+'/code_captcha/check_code',
            type: 'post',
            dataType: 'json',
            data: {captcha:captcha},
            async : false,
            success:function(data){
                if (data.code == '200') {
                    status = 1;
                } else {
					status = 0;
                }
            },
            error:function(){
            	status = 0;
            }
        });
        return status;
	}

	//检查手机
	function checkPhone(phone){
		var status = true;
		if (phone == '') {
			$('.num2-err').removeClass('hide').find("em").text('请输入手机号');
			return false;
		}
		var param = /^1[34578]\d{9}$/;
		if (!param.test(phone)) {
			// globalTip({'msg':'手机号不合法，请重新输入','setTime':3});
			$('.num2-err').removeClass('hide');
			$('.num2-err').text('手机号不合法，请重新输入');
			return false;
		}
		return status;
	}

	//检查手机验证码
	function checkPhoneCode(pCode){
		if (pCode == '') {
			$('.error').removeClass('hide').text('请输入验证码');
			return false;
		} else {
			$('.error').addClass('hide');
			return true;
		}
	}

	// 登录点击事件
	function sendBtn(){
		//账号登录
		if (tab == 'account_number') {
			$(".log-btn").click(function(){
				var inp = $.trim($('#num').val());
				var pass = $.trim($('#pass').val());
				if (checkAccount(inp) && checkPass(pass)) {
					var ldata = {userinp:inp,password:pass};
					$.ajax({
						type:'post',
						url:api+'/blog/dologin',
						data:ldata,
						dataType:'json',
						success:function(data){
							if (data.code == 200) {
								var res = $.cookie('_token',data.data,{path: '/' });
								var redirect_url = $('meta[name="Redirect_url"]').attr('content');
								if (redirect_url != null || redirect_url != undefined) {
									location.href=redirect_url;		
								}else{
									location.href="/blog";
								}
							}else if(data.code == 500){
								alert(data.data);
							}
						}
					});
				} else {
					return false;
				}
			});
		} else {
			// 短信登录
			$(".log-btn").click(function(){
				var phone = $.trim($('#num2').val());
				var pcode = $.trim($('#veri-code').val());
				var pcode = $.trim($('#veri-code').val());
				if (checkPhone(phone) && checkPhoneCode(pcode)) {
					console.log(phone);
			  		$.ajax({
						type:'post',
						url:api+'/blog/register',
						data:{phone:phone,code:pcode},
						dataType:'json',
						success:function(data){
							if (data.code == 200) {
								var res = $.cookie('_token',data.data,{path: '/' });
								var redirect_url = $('meta[name="Redirect_url"]').attr('content');
								if (redirect_url != null || redirect_url != undefined) {
									location.href=redirect_url;		
								}else{
									location.href="/blog";
								}
							}else if(data.code == 500){
								alert(data.data);
							}
						},
						error:function(data){
							$(".log-btn").off('click').addClass("off");
							$('.tel-warn').removeClass('hide').text('登录失败');
							return false;
						}
					});
				} else {
					$(".log-btn").off('click').addClass("off");
					$('.tel-warn').removeClass('hide').text('登录失败');
					return false;
				}
			});
		}
	}

	// 登录的回车事件
	$(window).keydown(function(event) {
    	if (event.keyCode == 13) {
    		$('.log-btn').trigger('click');
    	}
    });

	//发送短信验证码
	$(".form-data").delegate(".send","click",function () {
		var phone = $.trim($('#num2').val());
		var code = $.trim($('#veri').val());
		if (!checkPhone(phone)) {
			return false;
		}
		if (checkCode(code) == 0) {
			$('.img-err').removeClass('hide');
			getCode();
			return false;
		}
		$('.img-err').addClass('hide');
		$('.img-succ').removeClass('hide');
		$.ajax({
            url: api+'/api/code_captcha/phone_code',
            type: 'post',
            dataType: 'json',
            async: true,
            data: {phone:phone},
            success:function(data){
                if (data.code == '200') {
                	console.log(data.data);
                	alert('你的短信验证码是'+data.data)
                    timing();//开始计时
                } else if (data.code == '403') {
                	timing();//开始计时
                } else if (data.code == '405') {
                	$(".form-data .send").text(data.data);
                }else{
                	$(".form-data .send").text(data.data);
                }
            },
            error:function(){
                $(".form-data .send").text('发送短信失败，请稍后重试');
            }
        });
        
    });

	//计时
    function timing()
    {
    	var oTime = $(".form-data .time"),
		oSend = $(".form-data .send"),
		num = parseInt(oTime.text()),
		oEm = $(".form-data .time em");
	    $('.send').hide();
	    oTime.removeClass("hide");
	    var timer = setInterval(function () {
	   	var num2 = num-=1;
            oEm.text(num2);
            if(num2==0){
                clearInterval(timer);
                oSend.text("重新发送验证码");
			    oSend.show();
                oEm.text("120");
                oTime.addClass("hide");
            }
        },1000);
    }


    function getCookie(name)
		{
		var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
		if(arr=document.cookie.match(reg))
		return unescape(arr[2]);
		else
		return null;
		}

});