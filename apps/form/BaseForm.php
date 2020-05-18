<?php

namespace ServiceLaundry\Common\Forms;

use Phalcon\Forms\Form;
use Phalcon\Tag;

class BaseForm extends Form
{
    public function rendering($nameForm)
    {
        return $this->render($nameForm);
    }

    public function startForm()
    {
        return Tag::form($this->getUserOptions());
    }

    public function endForm()
    {
        return Tag::endForm();
    }
}

