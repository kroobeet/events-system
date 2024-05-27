@if(session()->has('success'))
    <div class="px-4 py-3 rounded relative" style="background-color: #1c7430; color: #eaeaea" role="alert">
        <span class="block sm:inline">{{ session()->get('success') }}</span>
    </div>
@elseif(session()->has('warning'))
    <div class="px-4 py-3 rounded relative" style="background-color: #c49121; color: #eaeaea" role="alert">
        <span class="block sm:inline">{{ session()->get('warning') }}</span>
    </div>
@elseif(session()->has('error'))
    <div class="px-4 py-3 rounded relative" style="background-color: #e83122; color: #eaeaea" role="alert">
        <span class="block sm:inline">{{ session()->get('warning') }}</span>
    </div>
@endif
