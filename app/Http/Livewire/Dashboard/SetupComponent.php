<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Setup;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class SetupComponent extends Component
{
    use AuthorizesRequests;
    use LivewireAlert;
    use WithFileUploads;

    public $name, $designation, $site_name, $site_url, $phone, $phone_two, $date_of_birth, $email, $email_two, $location, $facebook, $twitter, $youtube, $github, $about;
    public $setup;
    public $logo, $main_image, $about_image;
    public function mount()
    {
        $setup = Setup::first();
        $this->name = $setup->name;
        $this->designation = $setup->designation;
        $this->site_name = $setup->site_name;
        $this->site_url = $setup->site_url;
        $this->phone = $setup->phone;
        $this->phone_two = $setup->phone_two;
        $this->date_of_birth = $setup->date_of_birth;
        $this->email = $setup->email;
        $this->email_two = $setup->email_two;
        $this->location = $setup->location;
        $this->facebook = $setup->facebook;
        $this->twitter = $setup->twitter;
        $this->youtube = $setup->youtube;
        $this->github = $setup->github;
        $this->about = $setup->about;
        $this->setup = Setup::first();

    }

    public function updateSetup()
    {
        $data = $this->validate([
            'name' => ['required', 'min:2', 'max:33'],
            'designation' => ['required', 'max:99'],
            'site_name' => ['required'],
            'site_url' => ['required', 'url'],
            'phone' => ['required', 'numeric'],
            'phone_two' => ['required', 'numeric'],
            'date_of_birth' => ['required', 'date'],
            'email' => ['required', 'email'],
            'email_two' => ['required', 'email'],
            'location' => ['required'],
            'facebook' => ['required', 'url'],
            'twitter' => ['required', 'url'],
            'youtube' => ['required', 'url'],
            'github' => ['required', 'url'],
            'about' => ['sometimes'],
        ]);
        $this->setup->update($data);
        $this->alert('success', __('Data updated successfully'));
    }
    public function logoUpdate()
    {
        $this->validate([
            'logo' => ['required','image', 'max:1024']
        ]);
        if ($this->logo){
            $this->setup->clearMediaCollection();
            $a = $this->setup->addMedia($this->logo->getRealPath())->toMediaCollection('default');
//            unlink("media/".$a->id.'/'. $a->file_name);g
            $this->alert('success', __('Data updated successfully'));

            $this->reset('logo');
        }
    }
    public function mainImageUpdate()
    {
        $this->validate([
            'main_image' => ['required','image', 'max:1024']
        ]);
        if ($this->main_image){
            $this->setup->clearMediaCollection('main_image');
            $a = $this->setup->addMedia($this->main_image->getRealPath())->toMediaCollection('main_image');
            unlink("media/".$a->id.'/'. $a->file_name);
            $this->alert('success', __('Data updated successfully'));

            $this->reset('main_image');

        }
    }
    public function aboutImageUpdate()
    {
        $this->validate([
            'about_image' => ['required','image', 'max:1024']
        ]);
        if ($this->about_image){
            $this->setup->clearMediaCollection('about_image');
            $a = $this->setup->addMedia($this->about_image->getRealPath())->toMediaCollection('about_image');
            unlink("media/".$a->id.'/'. $a->file_name);
            $this->alert('success', __('Data updated successfully'));

            $this->reset('about_image');
        }
    }
    public function render()
    {
        $this->authorize('isAdmin');
        return view('livewire.dashboard.setup-component');
    }
}
