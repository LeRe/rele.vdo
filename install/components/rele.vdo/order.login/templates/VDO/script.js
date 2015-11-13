var vdo = (function(){	
	return {
		componentPath: '',
		buttonHandler:
			function(listener) 
			{				
				var path = this.componentPath + '/ajax/check.php';
				var vdonumber = document.getElementsByName('vdonumber')[0].value;
				var vdocustomer = document.getElementsByName('vdocustomer')[0].value;
				var popup = new BX.PopupWindow(
						'vdo-orderLogin-popupMessage',
						document.vdoOrderLoginForm, {
							autoHide : true,
							offsetTop : 10,
							//offsetRight : 50,
							lightShadow : true,
							closeIcon : true,
							closeByEsc : true,
							overlay: {
								backgroundColor: 'gray',
								opacity: 50
							},
							events: { 
								onPopupClose : function(popupWindow){
										popupWindow.destroy();
										BX.bind(BX("vdo-orderLogin-submit"), "click", listener);
								} 
							}
						});

				BX.unbind(BX("vdo-orderLogin-submit"), "click", listener);

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
								popup.setContent(BX('vdo-orderLogin-popup').innerHTML = BX.message('JS_VDO_ORDER_NOT_FOUND'));
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
					popup.setContent(BX('vdo-orderLogin-popup').innerHTML = BX.message('JS_VDO_NOT_ENOUGH_DATA'));
					popup.show();
				}				
			}
	}
})();
