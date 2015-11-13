<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class СOrderLogin extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->InitComponentTemplate('');
		$template = & $this->GetTemplate();
		$templateFile = $template->GetFile();

		$this->arResult['PATH'] = $this->arParams["PATH"];
		$this->arResult['COMPONENT_PATH'] = str_replace('template.php', '', $templateFile);

		$this->ShowComponentTemplate();
	}	
}
