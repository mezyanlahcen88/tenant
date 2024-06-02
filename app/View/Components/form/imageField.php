<?php

namespace App\View\Components\form;

use Illuminate\View\Component;

class ImageField extends Component
{
    public $backgroundUrl;
    public $imageUrl;
    public $avatarName;

    public function __construct($backgroundUrl = '/assets/media/svg/avatars/blank.svg', $imageUrl = '/assets/media/avatars/300-1.jpg', $avatarName = 'avatar')
    {
        $this->backgroundUrl = $backgroundUrl;
        $this->imageUrl = $imageUrl;
        $this->avatarName = $avatarName;
    }

    public function render()
    {
        return view('components.form.image-field');
    }
}
