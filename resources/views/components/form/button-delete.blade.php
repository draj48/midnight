<form action="{{$route}}" method="POST" class="d-inline-block">
    @method('POST')
    @csrf
    <button type="submit" class="text-gray-500 hover:text-primary-500 dark:text-gray-300 dark:hover:text-primary-500 w-6 h-6 flex items-center justify-center" title="Delete">
        <x-ui.icon name="delete" stroke-width="2" class="w-5 h-5"/>
    </button>
</form>
