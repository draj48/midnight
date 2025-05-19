@extends('layouts.admin')
@section('content')
    <div class="max-w-7xl w-full mx-auto" x-data="post()">

        <form method="post">
            @csrf
            <ul class="space-y-4 sortable-menu mb-4">
                <template x-for="(menu, index) in menus" :key="index">
                    <li class="sortable-item">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 flex-1">

                            <x-form.input type="hidden" name="menu[][sortable]" class="sortable-input"
                                          x-model="index"
                                          x-bind:name="`menu[${index}][sortable]`"/>
                            <input type="hidden" x-bind:name="`menu[${index}][id]`" x-model="menu.id">
                            <div class="col-span-2">
                                <div class="py-3 px-3 flex items-center gap-x-4">
                                    <x-form.switch type="checkbox" id="status" value="active" name="menu[][status]"  x-bind:name="`menu[${index}][status]`" x-bind:checked="menu.status === 'active'"/>
                                    <div class="w-5 h-5 flex items-center justify-center cursor-pointer hover:text-primary-500 dark:text-gray-300"
                                         x-on:click="moveItemUp(index)" x-show="index > 0">
                                        <x-ui.icon name="arrow-up" class="w-4 h-4" stroke="currentColor"/>
                                    </div>
                                    <div class="w-5 h-5 flex items-center justify-center cursor-pointer hover:text-primary-500 dark:text-gray-300"
                                         x-on:click="moveItemDown(index)" x-show="index < menus.length - 1">
                                        <x-ui.icon name="arrow-down" class="w-4 h-4" stroke="currentColor"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <x-form.select x-model="menu.layout" x-bind:name="`menu[${index}][layout]`">
                                    <option value="all">{{__('All')}}</option>
                                    <option value="header">{{__('Header')}}</option>
                                    <option value="footer">{{__('Footer')}}</option>
                                </x-form.select>
                            </div>
                            <div class="col-span-3">
                                <x-form.input type="text" name="menu[][title]"
                                              placeholder="{{__('Title')}}" x-model="menu.title"
                                              x-bind:name="`menu[${index}][title]`"/>
                            </div>
                            <div class="col-span-3">
                                <x-form.input type="text" name="menu[][url]"
                                              placeholder="{{__('http://')}}" x-model="menu.url"
                                              x-bind:name="`menu[${index}][url]`"/>
                            </div>
                            <div class="col-span-2">
                                <x-form.secondary x-bind:disabled="menu.static === 'active'" type="button"
                                                  @click="removeMenuField(index,menu.id)"
                                                  class="w-full">{{__('Remove')}}</x-form.secondary>
                            </div>
                        </div>
                    </li>
                </template>
                <x-form.secondary type="button" @click="addMenuField()"
                                  class="w-full">{{__('Add new')}}</x-form.secondary>
            </ul>
            <x-form.primary class="w-full">{{__('Save change')}}</x-form.primary>
        </form>
    </div>

    @push('javascript')

        <script src="{{asset('static/js/jquery.js')}}"></script>
        <script src="{{asset('static/js/sortable.js')}}"></script>
        <script>


            function post() {
                return {
                    menus: {!! isset($menuFetch) ? "JSON.parse('".addslashes(json_encode($menuFetch, JSON_UNESCAPED_SLASHES))."')" : '[]' !!},
                    removeMenuField(index, menuId = null) {
                        this.menus.splice(index, 1);
                        if (menuId) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                                }
                            });
                            $.ajax({
                                url: '{{route('admin.menu.destroy')}}?id=' + menuId,
                                type: 'DELETE',
                                dataType: 'json',
                                success: function(response) {
                                }
                            });
                        }
                    },
                    addMenuField() {
                        var sortIndex = this.menus.length+1
                        this.menus.push({
                            title: '',
                            url: '',
                            layout: '',
                            static: '',
                            status: 'active',
                            sortable: sortIndex,
                        });
                        sortable('.sortable-menu', 'reload');
                    }, moveItemUp(index) {
                        if (index > 0) {
                            var temp = this.menus[index - 1];
                            this.menus[index - 1] = this.menus[index];
                            this.menus[index] = temp;
                        }
                    }, moveItemDown(index) {
                        if (index < this.menus.length - 1) {
                            var temp = this.menus[index + 1];
                            this.menus[index + 1] = this.menus[index];
                            this.menus[index] = temp;
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
