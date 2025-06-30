<?php

namespace App\Livewire\Admin;

use App\Models\About;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.layout')]
class AboutSetting extends Component
{
    use WithFileUploads;
    public $story, $mission, $story_image, $mission_image, $existing_story_image, $existing_mission_image;

    public function mount()
    {
        $about = About::where('id', 1)->firstOrFail();
        $this->story = $about->story;
        $this->mission = $about->mission;
        $this->existing_story_image = $about->story_image;
        $this->existing_mission_image = $about->mission_image;
    }

    public function updateAbout()
    {
        $this->validate([
            'story' => 'required|string',
            'mission' => 'required|string',
            'story_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'mission_image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $about = About::where('id', 1)->firstOrFail();

        // check dimension
        if (!empty($this->mission_image)) {
            $manager = ImageManager::withDriver(new Driver);
            $img = $manager->read($this->mission_image->getRealPath());
            $width = $img->width();
            $height = $img->height();

            $expectedRatio = 1 / 1;
            $actualRatio = $width / $height;
            $tolerance = 0.02;
            if (abs($actualRatio - $expectedRatio) > $tolerance) {
                $this->addError("mission_image", "Mission image must have a 1:1 aspect ratio.");
                return;
            }
        }
        if (!empty($this->story_image)) {

            $manager = ImageManager::withDriver(new Driver);
            $img = $manager->read($this->story_image->getRealPath());
            $width = $img->width();
            $height = $img->height();

            $expectedRatio = 1 / 1;
            $actualRatio = $width / $height;
            $tolerance = 0.02;
            if (abs($actualRatio - $expectedRatio) > $tolerance) {
                $this->addError("story_image", "Story image must have a 1:1 aspect ratio.");
                return;
            }
        }

        //end check


        $about->update([
            'story' => str($this->story)->trim(),
            'mission' => str($this->mission)->trim()
        ]);

        if (!empty($this->story_image)) {

            $manager = ImageManager::withDriver(new Driver);
            $img = $manager->read($this->story_image->getRealPath());
            $width = $img->width();
            $height = $img->height();

            $expectedRatio = 1 / 1;
            $actualRatio = $width / $height;
            $tolerance = 0.02;
            if (abs($actualRatio - $expectedRatio) > $tolerance) {
                $this->addError("story_image", "Story image must have a 1:1 aspect ratio.");
                return;
            }

            $path = $this->story_image->store('about', 'public');
            $about->update([
                'story_image' => $path
            ]);
        }


        if (!empty($this->mission_image)) {
            $manager = ImageManager::withDriver(new Driver);
            $img = $manager->read($this->mission_image->getRealPath());
            $width = $img->width();
            $height = $img->height();

            $expectedRatio = 1 / 1;
            $actualRatio = $width / $height;
            $tolerance = 0.02;
            if (abs($actualRatio - $expectedRatio) > $tolerance) {
                $this->addError("mission_image", "Mission image must have a 1:1 aspect ratio.");
                return;
            }
            $path = $this->mission_image->store('about', 'public');
            $about->update([
                'mission_image' => $path
            ]);
        }

        $this->reset(['story', 'mission', 'story_image', 'mission_image', 'existing_story_image', 'existing_mission_image']);
        redirect()->route('admin.settings.about')->with('success', 'About details updated successfully');
    }
    public function render()
    {
        return view('livewire.admin.about-setting');
    }
}
