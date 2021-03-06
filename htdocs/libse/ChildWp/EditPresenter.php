<?php
/***************************************************************************
 *  For license information see doc/license.txt
 *
 *  Unicode Reminder メモ
 ***************************************************************************/

class ChildWp_EditPresenter extends ChildWp_Presenter
{
  public function __construct($request = false, $translator = false)
  {
    parent::__construct($request, $translator);
  }

  protected function getTitle()
  {
		global $translate;
    return $translate->t('Edit waypoint', '', '', 0);
  }

  protected function getSubmitButton()
  {
		global $translate;
    return $translate->t('Save', '', '', 0);
  }

  protected function onDoSubmit($coordinate, $description)
  {
    $this->childWpHandler->update($this->childId, $this->getType(), $coordinate->latitude(), $coordinate->longitude(), $description);
  }

  protected function onPrepare($template)
  {
    $template->assign(self::tpl_child_id, $this->childId);
  }
}
