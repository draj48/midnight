@props([
    'id' => 'editor-'. str()->random(8),
    'height' => '400px',
    'label' => null,
    'name' => null,
    'value' => null,
    'noMargin' => false,
    'readonly' => false,
    'disabled' => false,
    'toolbar' => true
])

<div class="{{ $noMargin ? 'mb-0' : 'mb-5' }}">
    <div x-data="{
	height: '{{ $height }}',
	tab: 'write',
	@if ($attributes->has('wire:model'))
	 content: @entangle($attributes->wire('model')),
	@else
	 content: {{ collect($value) }},
	@endif
	showConvertedMarkdown: false,
	convertedContent: '',
	convertedMarkdown() { 
	 this.showConvertedMarkdown = true;
	 this.convertedContent = marked.parse(DOMPurify.sanitize(this.content));
	},
	replaceSelectedText(replacementText, newCharactersLength) {
		// 1. obtain the object reference for the textarea
		const textareaRef = this.$refs.input;
		// 2. obtain the index of the first selected character
		let start = textareaRef.selectionStart;
		// 3. obtain the index of the last selected character
		let finish = textareaRef.selectionEnd;
		// 4. obtain all the text content
		const allText = textareaRef.value;
		// 5. Bind 'allText' to the 'content' data object
		this.content = allText.substring(0, start) + replacementText + allText.substring(finish, allText.length);
		// 6. Put the cursor to the end of selected text
		this.$nextTick(() => this.setCursorPosition(this.$refs.input, finish + newCharactersLength));
	},
	setCursorPosition(el, pos) {
	 el.focus();
	 el.setSelectionRange(pos, pos);
	},
	toggleMenu(value) {
		let selectedString = document.getSelection();
		let linkText = selectedString.toString().startsWith('http') ? selectedString : 'Your link';

		switch (value) {
			case 'bold': 
			this.replaceSelectedText(`**${selectedString}**`, 4);
			break;

			case 'italic': 
			this.replaceSelectedText(`*${selectedString}*`, 2);
			break;

			case 'quote': 
			this.replaceSelectedText(`> ${selectedString}`, 2);
			break;

			case 'heading':
			this.replaceSelectedText(`### ${selectedString}`, 4);
			break;

			case 'fullscreen': 
			this.$refs.input.classList.add('fullscreen');
			break;
		}
	},

	removeFullscreen() {
		if ( this.$refs.input.classList.contains('fullscreen')) {
		    this.$refs.input.classList.remove('fullscreen');
		}
	}
	}"
         x-on:keyup.escape.window="removeFullscreen()"
         class="relative bg-white border border-gray-300 dark:border-gray-800 dark:bg-gray-800 rounded-lg" x-cloak wire:ignore>

        <div class="flex items-center text-gray-400 pr-4">
            <div class="flex-1 flex items-center gap-x-3 px-4 pt-1 text-sm">
                <button type="button" class="py-3 inline-block font-medium" :class="{ 'text-primary-500': tab === 'write' }" x-on:click.prevent="tab = 'write'; showConvertedMarkdown = false">Write</button>
                <button type="button" class="py-3 inline-block font-medium" :class="{ 'text-primary-500': tab === 'preview' && showConvertedMarkdown === true }" x-on:click.prevent="tab = 'preview'; convertedMarkdown()">Preview</button>
            </div>
            @if ($toolbar)
                <button x-tooltip="'bold'" type="button" class="py-2 px-2 inline-block group" x-on:click.prevent="toggleMenu('bold')">
                    <svg class="h-4 w-4 text-gray-500 group-hover:text-primary-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M0 64C0 46.3 14.3 32 32 32H80 96 224c70.7 0 128 57.3 128 128c0 31.3-11.3 60.1-30 82.3c37.1 22.4 62 63.1 62 109.7c0 70.7-57.3 128-128 128H96 80 32c-17.7 0-32-14.3-32-32s14.3-32 32-32H48V256 96H32C14.3 96 0 81.7 0 64zM224 224c35.3 0 64-28.7 64-64s-28.7-64-64-64H112V224H224zM112 288V416H256c35.3 0 64-28.7 64-64s-28.7-64-64-64H224 112z"></path></svg>
                </button>
                <button x-tooltip="'italic'" type="button" class="py-2 px-2 inline-block group" x-on:click.prevent="toggleMenu('italic')">
                    <svg class="h-4 w-4 text-gray-500 group-hover:text-primary-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M128 64c0-17.7 14.3-32 32-32H352c17.7 0 32 14.3 32 32s-14.3 32-32 32H293.3L160 416h64c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H90.7L224 96H160c-17.7 0-32-14.3-32-32z"></path></svg>
                </button>

                <button x-tooltip="'quote'" type="button" class="py-2 px-2 inline-block group" x-on:click.prevent="toggleMenu('heading')">
                    <svg class="h-4 w-4 text-gray-500 group-hover:text-primary-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 64C0 46.3 14.3 32 32 32H80h48c17.7 0 32 14.3 32 32s-14.3 32-32 32H112V208H336V96H320c-17.7 0-32-14.3-32-32s14.3-32 32-32h48 48c17.7 0 32 14.3 32 32s-14.3 32-32 32H400V240 416h16c17.7 0 32 14.3 32 32s-14.3 32-32 32H368 320c-17.7 0-32-14.3-32-32s14.3-32 32-32h16V272H112V416h16c17.7 0 32 14.3 32 32s-14.3 32-32 32H80 32c-17.7 0-32-14.3-32-32s14.3-32 32-32H48V240 96H32C14.3 96 0 81.7 0 64z"></path></svg>
                </button>
                <button x-tooltip="'quote'" type="button" class="py-2 px-2 inline-block group" x-on:click.prevent="toggleMenu('quote')">
                    <svg class="h-4 w-4 text-gray-500 group-hover:text-primary-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 216C0 149.7 53.7 96 120 96h8c17.7 0 32 14.3 32 32s-14.3 32-32 32h-8c-30.9 0-56 25.1-56 56v8h64c35.3 0 64 28.7 64 64v64c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V320 288 216zm256 0c0-66.3 53.7-120 120-120h8c17.7 0 32 14.3 32 32s-14.3 32-32 32h-8c-30.9 0-56 25.1-56 56v8h64c35.3 0 64 28.7 64 64v64c0 35.3-28.7 64-64 64H320c-35.3 0-64-28.7-64-64V320 288 216z"></path></svg>
                </button>
            @endif

            <div class="relative" x-data="{ open: false }" x-on:click.away="open = false" x-on:close.stop="open = false">
                <button x-tooltip="'Markdown Cheatsheet'" type="button" class="rounded-lg py-2 px-2 inline-block group focus:ring-1 focus:ring-indigo-200" x-on:click="open = ! open">
                    <svg class="h-4 w-4 text-gray-500 group-hover:text-primary-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path></svg>
                </button>
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute z-50 mt-2 w-80 rounded-md shadow-lg origin-top-right right-0 -mr-5"
                     style="display: none;"
                     x-on:click="open = false">
                    <div class="rounded-md ring-1 ring-black ring-opacity-5 p-4 bg-white dark:bg-gray-900 text-sm">
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Heading</div>
                            <div class="text-gray-800 dark:text-white flex-1 font-mono text-xs mt-1">## Heading H2</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Bold</div>
                            <div class="text-gray-800 dark:text-white flex-1 font-mono text-xs mt-1">**bold text**</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Italic</div>
                            <div class="text-gray-800 dark:text-white flex-1 font-mono text-xs mt-1">*italicized text*</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Blockquote</div>
                            <div class="text-gray-800 dark:text-white flex-1 font-mono text-xs mt-1">> blockquote</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Ordered List</div>
                            <div class="text-gray-800 dark:text-white flex-1 font-mono text-xs mt-1">
                                1. First <br>
                                2. Second
                            </div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Unordered List</div>
                            <div class="text-gray-800 dark:text-white flex-1 font-mono text-xs mt-1">
                                - First <br>
                                - Second
                            </div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Horizontal Rule</div>
                            <div class="text-gray-800 dark:text-white flex-1 font-mono text-xs mt-1">---</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Link</div>
                            <div class="text-gray-800 dark:text-white flex-1 font-mono text-xs mt-1">[title](url)</div>
                        </div>
                        <div class="flex py-1">
                            <div class="flex-shrink-0 text-gray-500 flex-1 text-right pr-5">Image</div>
                            <div class="text-gray-800 dark:text-white flex-1 font-mono text-xs mt-1">![alt](image.jpg)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-form.textarea class="!bg-transparent !border-0 !ring-0 h-48 resize-none" spellcheck="false" x-show="! showConvertedMarkdown" id="{{ $id }}" x-ref="input" x-model="content" name="{{ $name }}"  :style="`height: ${height} !important; max-width: 100%`"></x-form.textarea>
        <div x-show="showConvertedMarkdown">
            <div x-html="convertedContent" class="w-full prose max-w-none prose-white dark:prose-invert leading-6 p-5 overflow-y-auto h-48"></div>
        </div>
    </div>

    @error($name)
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>


@pushOnce('javascript')
    <script src="https://cdn.jsdelivr.net/npm/marked@4.0.12/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dompurify@2.3.6/dist/purify.min.js"></script>
@endpushOnce