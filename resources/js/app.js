import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

import tippy from 'tippy.js';

import.meta.glob([
    '../img/**',
    '../fonts/**',
]);

Alpine.directive('clipboard', (el) => {
    let text = el.textContent

    el.addEventListener('click', () => {
        navigator.clipboard.writeText(text)
    })
})
Livewire.start()

tippy('.tooltip', {
    theme: 'tailwind',
    animation: 'shift-toward',
    duration: 100,
    arrow: true,
});

// Light switcher
const lightSwitches = document.querySelectorAll('.light-switch');

if (lightSwitches.length > 0) {
    lightSwitches.forEach((lightSwitch, i) => {
        if (localStorage.getItem('dark-mode') === 'true') {
            // eslint-disable-next-line no-param-reassign
            lightSwitch.checked = true;
        }
        lightSwitch.addEventListener('change', () => {
            const { checked } = lightSwitch;
            lightSwitches.forEach((el, n) => {
                if (n !== i) {
                    // eslint-disable-next-line no-param-reassign
                    el.checked = checked;
                }
            });
            if (lightSwitch.checked) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('dark-mode', true);
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('dark-mode', false);
            }
        });
    });
}

