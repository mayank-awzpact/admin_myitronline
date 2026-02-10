<div class="dropdown">
    <button class="btn  dropdown-toggle" type="button" id="languageSwitcher" data-bs-toggle="dropdown" aria-expanded="false">
        {{ strtoupper(app()->getLocale()) }}
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageSwitcher">
        <li><a class="dropdown-item" href="#" wire:click.prevent="switchLanguage('en')">English</a></li>
        <li><a class="dropdown-item" href="#" wire:click.prevent="switchLanguage('hi')">हिन्दी</a></li>
    </ul>
</div>
