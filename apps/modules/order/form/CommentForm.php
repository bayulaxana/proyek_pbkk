<?php

namespace ServiceLaundry\Order\Forms\Web;

use ServiceLaundry\Common\Forms\BaseForm;

use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class CommentForm extends BaseForm
{
    public function initialize($entity = null, $options = null)
    {
        $commentDetails = new TextArea('comment_content');

        $commentDetails->setLabel('Detail Komentar');
        $commentDetails->setFilters(['striptags', 'string']);
        $commentDetails->setAttribute('rows', 2);
        $commentDetails->setAttribute('placeholder', 'Tulis catatan komentar baru');
        $commentDetails->addValidators([
            new PresenceOf(['message' => 'Anda harus menuliskan detail komentar'])
        ]);

        $submit = new Submit('Kirim');

        $this->add($commentDetails);
        $this->add($submit);
    }
}