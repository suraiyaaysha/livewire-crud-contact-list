<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contact;

class Contacts extends Component
{
    public $name;
    public $email;
    public $contactId;
    public $isEditing = false; // Add this line to initialize the isEditing property

    public function render()
    {
        $contacts = Contact::all();
        return view('livewire.contacts', compact('contacts'));
    }

    public function create()
    {
        // Create a new contact
        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Reset the input fields
        $this->name = '';
        $this->email = '';

        // Emit a refresh event to update the contact list
        $this->emit('refresh');
    }

    public function edit($contactId)
    {
        // Load the contact information based on the ID
        $contact = Contact::find($contactId);

        // Set the input fields to the loaded contact details
        $this->name = $contact->name;
        $this->email = $contact->email;
        $this->contactId = $contact->id;

        // Set the editing state to true
        $this->isEditing = true;
    }

    public function update()
    {
        // Find the contact based on the ID
        $contact = Contact::find($this->contactId);

        // Update the contact details if the contact exists
        if ($contact) {
            $contact->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
        }

        // Reset the input fields and editing state
        $this->name = '';
        $this->email = '';
        $this->isEditing = false;

        // Emit a refresh event to update the contact list
        $this->emit('refresh');
    }

    public function delete($contactId)
    {
        // Delete the contact based on the ID
        Contact::destroy($contactId);

        // Emit a refresh event to update the contact list
        $this->emit('refresh');
    }

    public function loadContact($contactId)
    {
        $this->edit($contactId);
    }
}

