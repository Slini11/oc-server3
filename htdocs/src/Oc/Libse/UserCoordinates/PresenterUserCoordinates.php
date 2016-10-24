<?php
/***************************************************************************
 *  For license information see doc/license.txt
 *
 *  Unicode Reminder メモ
 ***************************************************************************/

namespace Oc\Libse\UserCoordinates;

use Oc\Libse\Coordinate\PresenterCoordinate;
use Oc\Libse\Validator\AlwaysValidValidator;

class PresenterUserCoordinates
{
    const tpl_incl_coord = 'inclCoord';
    const image = 'resource2/ocstyle/images/misc/wp_note.png';

    private $request;
    private $translator;
    private $coordinate;
    private $user;

    public function __construct($request = false, $translator = false)
    {
        $this->request = $request;
        $this->translator = $translator;
        $this->coordinate = new PresenterCoordinate($this->request, $this->translator);
    }

    public function init($user)
    {
        $this->user = $user;
        $this->coordinate->init($this->user->getLatitude(), $this->user->getLongitude());
    }

    /**
     * @param \OcSmarty $template
     */
    public function prepare($template)
    {
        $template->assign(self::tpl_incl_coord, $this->coordinate->hasCoordinate());
        $this->coordinate->prepare($template);
    }

    public function validate()
    {
        $this->coordinate->validate();
        return true;
    }

    public function doSubmit()
    {
        $coordinate = $this->getCoordinate();
        $this->user->setLatitude($coordinate->latitude());
        $this->user->setLongitude($coordinate->longitude());

    }

    private function getCoordinate()
    {
        return $this->coordinate->getCoordinate();
    }

}
