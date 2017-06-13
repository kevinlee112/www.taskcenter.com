//浮层显示
function show_album(id,data,page)
{
	if(!page)
	{
		page = 1;
	}

	$.ajax({
		type:'post',
		url:"/manager/album/list.json",
		data: "id="+id+"&page="+page,
		dataType:'json',
		success:function(res){
			if(res.error == 1)
			{
				$("#show_pictures").show();
				$('.fade').show();
				$('.upload_file').removeClass('upload_file'); //去掉所有
				$('#'+data).parents('.col-lg-7').find('input:hidden').addClass("upload_file"); //选中的下边添加上传文件标示class
				$("#path_id").replaceWith("<input type='hidden' name='path_id' value='"+id+"' id='path_id'>");
				$("#current_box").replaceWith("<input type='hidden' name='current_box' id='current_box' value='"+data+"'>");

				if(res.result.path) //导航
				{
					var path = '';
					for(mkey in res.result.path)
					{
						if(id == res.result.path[mkey]["id"])
						{
						    path += '<li class="active"><a href="javascript:show_album('+res.result.path[mkey]["id"]+',\''+data+'\','+page+')">'+res.result.path[mkey]["path_name"]+'</a><input type="hidden" id="current_dir" value="'+id+'"></li>';
						}
						else
						{
							path += '<li><a href="javascript:show_album('+res.result.path[mkey]["id"]+',\''+data+'\','+page+')">'+res.result.path[mkey]["path_name"]+'</a></li>';
						}
					}
					$('.bg-primary').html(path);
				}

				if(res.result.albums) //相册
				{
					var albums_str = '';

					for(skey in res.result.albums)
					{
						albums_str += '<li><i class="fa fa-folder"></i><a href="javascript:show_album('+res.result.albums[skey]["id"]+',\''+data+'\','+page+')">'+res.result.albums[skey]["path_name"]+'</a></li>';
					}

					$('.make_dir').html(albums_str);
				}

				if(res.result.list)
				{
					var pic_str ='';

					for(pkey in res.result.list)
					{
						pic_str += '<li><img src="'+res.result.list[pkey]['url']+'" onclick="choose_pic(this)">'+res.result.list[pkey]['name']+'</li>';
					}

					$('.pic_list').html(pic_str);
				}

				if(res.result.page_html)
				{
					$('.page').html(res.result.page_html)
				}
			}
		}
	});
}

//分页数据
function get_page(page)
{
	var id = $('#current_dir').val();
	var data = $('#current_box').val();
	show_album(id,data,page);
}

//创建目录浮层
function make_album()
{
	if($('.make_dir li').length > 20)
	{
		alert("最多只能创建10个目录！");
		return false;
	}

	if($('.make_dir').find('input').length <= 0)
	{
		var dir_str = '<li><i class="fa fa-folder"></i><input type="text" style="width:60px;" name="new_path_name" onblur="addalbum(this.value)" id="new_path_name" value="name" /></li>';
		$('.make_dir').append(dir_str);
	}
}

//创建目录提交
function addalbum(path_name)
{
	var pid = $('#current_dir').val();

	if(path_name == '')
	{
		alert("请输入目录名称！");
		return false;
	}

	$.ajax({
		type:'post',
		url:"/manager/album/makealbum.json",
		data: "pid="+pid+"&path_name="+path_name,
		dataType:'json',
		success:function(res){
			if(res.error == 1)
			{
				$(".make_dir input").replaceWith('<a href="javascript:show_album('+res.result+')">'+path_name+'</a>');
			}
			else
			{
				alert("目录创建失败");
				$('#new_dir').onfocus();
			}
		}
	})
}

//上传图片
function setImageName(data)
{
	if(!/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(data.value))
	{
		alert('只能上传图片');
		return false;
	}
	if (data.size > 2097152)
	{
		alert('文件大小超过2M');
		return false;
	}

	var formData = new FormData(document.getElementById("fileinfo"));

	$.ajax({
		url:"/manager/album/upload.json",
		type: "POST",
		data: formData,
		contentType: false, // 告诉jQuery不要去设置Content-Type请求头
		processData: false, // 告诉jQuery不要去处理发送的数据
		dataType:'json',
		success:function(res){
			if(res.result == true)
			{
				if($('.pic_list li').length == 0)
				{
					$('.pic_list').append('<li><img src="'+res.info.furl+'" onclick="choose_pic(this)">'+res.info.pic_name+'</li>');
				}
				else
				{
					$('.pic_list').prepend('<li><img src="'+res.info.furl+'" onclick="choose_pic(this)">'+res.info.pic_name+'</li>');
					$('.pic_list li:last').remove();
				}
			}
			else
			{
				alert("图片上传失败！");
			}
		}
	})
}


//点击图片选中
function choose_pic(image)
{

	$('.upload_file').empty();
	$('.upload_file').val(image.src);
	$('.upload_file').parents('.col-lg-7').find('.yulan').html("<img src='"+image.src+"' class='show_pic'>");
	$("#show_pictures").hide();
	$('#current_box').val('');
	$('.fade').hide();
	$('.modal-open').removeClass('modal-open');
	$('.show_pictures').attr('aria-hidden','true');
}




