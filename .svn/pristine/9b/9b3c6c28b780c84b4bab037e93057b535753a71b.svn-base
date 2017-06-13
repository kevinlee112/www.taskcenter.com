//上传处理
function uploadStart(file) {
	try {
		swfu.setPostParams({'cookie':document.cookie});
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("图片上传中...");
		progress.toggleCancel(true, this);
	}
	catch (ex) {}
	return true;
}

//上传成功
function uploadSuccess(file, serverData) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		progress.setStatus("上传完成.");
		progress.toggleCancel(false);
		
		var data = jQuery.parseJSON(serverData);

		if(data.result)
		{
			showUploadPic(data.info);
		}
		else
		{
			alert('图片上传失败：'+data.info.msg);
		}
	} catch (ex) {
		this.debug(ex);
	}
}

//显示上传图片
function showUploadPic(data)
{
	try {
		var show_html = '<input type="hidden" value="'+data.furl+'" name="bg_image"/><a href="'+data.furl+'" target="_blank"><img src="'+data.furl+'" width="100"/></a>';
		jQuery('#img_div').html(show_html);
		$('.progressName').show();
		$('.progressWrapper').show();
	}
	catch (ex) {}
}