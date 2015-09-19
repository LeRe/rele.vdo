var vdo = (function(){
	return {
		componentPath: '',
		buttonHandler:
			function() 
			{
				var path = this.componentPath + '/ajax/check.php';
				var vdonumber = document.getElementsByName('vdonumber')[0].value;
				var vdocustomer = document.getElementsByName('vdocustomer')[0].value;
				var popup = new BX.PopupWindow(
						'vdoPopupMessage',
						document.vdoOrderLoginForm, {
							autoHide : true,
							offsetTop : 25,
							//offsetRight : 50,
							lightShadow : true,
							closeIcon : false,
							closeByEsc : true,
							overlay: {
								backgroundColor: 'gray',
								opacity: 50
							},
							events: { 
								onPopupClose : function(popupWindow){
										popupWindow.destroy(); 
								} 
							}
						});				

				if(vdonumber != '' && vdocustomer !='') 
				{
					BX.ajax.get(
						path,
						'vdonumber='+vdonumber+'&vdocustomer='+vdocustomer,
						function (data)
						{
							var data = JSON.parse(data);
							if(!data.orderExist)
							{
								popup.setContent('<div style="margin: 10px">'+
									BX.message('JS_VDO_ORDER_NOT_FOUND')+
									'</div>');
								popup.show();								
							}
							else
							{
								document.vdoOrderLoginForm.submit();
							}
						}
					);	
				}
				else 
				{
					popup.setContent('<div style="margin: 10px">'+
						BX.message('JS_VDO_NOT_ENOUGH_DATA')+
						'</div>');
					popup.show();
				}				
			}
	}
})();





