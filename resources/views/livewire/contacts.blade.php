<div x-data="{ isOpen: false, isEditing: false }" class="pt-4">
    <button x-show="!isOpen" x-cloak @click="isOpen = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Contact</button>

    <form x-show="isOpen && !isEditing" x-cloak wire:submit.prevent="create" class="w-1/4">
        <h1 class="h-1 mb-6 text-xl font-semibold">Create New Contact:</h1>
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name:</label>
            <input type="text" id="name" wire:model="name" class="form-input mt-1 block w-full">
            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" id="email" wire:model="email" class="form-input mt-1 block w-full">
            @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create</button>
    </form>

    <div x-show="isEditing" x-cloak>
        <form wire:submit.prevent="update" class="w-1/4">

            <h1 class="h-1 mb-6 text-xl font-semibold">Update Contact:</h1>

            <div class="mb-4">
                <label for="edit-name" class="block text-gray-700">Name:</label>
                <input type="text" id="edit-name" wire:model="name" class="form-input mt-1 block w-full">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="edit-email" class="block text-gray-700">Email:</label>
                <input type="email" id="edit-email" wire:model="email" class="form-input mt-1 block w-full">
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Update</button>
        </form>
    </div>

    <table class="mt-8 border-collapse border">
        <thead class="border">
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($contacts->count())

                @foreach($contacts as $contact)
                <tr>
                    <td class="border px-4 py-2">{{ $contact->name }}</td>
                    <td class="border px-4 py-2">{{ $contact->email }}</td>
                    <td class="border px-4 py-2">
                        <button x-show="!isEditing" x-cloak @click="isEditing = true; isOpen = true; $nextTick(() => { $wire.loadContact({{ $contact->id }}) })" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Edit</button>
                        <button wire:click="delete({{ $contact->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                    </td>
                </tr>
                @endforeach

            @else
                <tr>
                    <td class="px-4 py-2">No Contact found!</td>
                </tr>
            @endif

        </tbody>
    </table>
</div>

@push('scripts')
<script>
    Livewire.on('loadContact', contactId => {
        Alpine.store('contactData', {
            id: contactId,
            isEditing: true
        });
    });
</script>
@endpush
