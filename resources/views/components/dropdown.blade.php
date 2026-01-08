@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white dark:bg-gray-700'])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-48',
    default => $width,
};
@endphp

<div class="relative js-dropdown-container">
    <div class="js-dropdown-trigger">
        {{ $trigger }}
    </div>

    <div class="js-dropdown-menu absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }} hidden"
            style="transition: opacity 0.2s ease-out, transform 0.2s ease-out; opacity: 0; transform: scale(0.95);">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>

<script>
    (function() {
        // Initialize all dropdowns
        function initDropdowns() {
            const containers = document.querySelectorAll('.js-dropdown-container');
            
            containers.forEach(container => {
                // Skip if already initialized
                if (container.dataset.initialized === 'true') return;
                container.dataset.initialized = 'true';
                
                const trigger = container.querySelector('.js-dropdown-trigger');
                const dropdown = container.querySelector('.js-dropdown-menu');
                
                if (!trigger || !dropdown) return;

                let isOpen = false;

                function showDropdown() {
                    dropdown.classList.remove('hidden');
                    void dropdown.offsetHeight; // Force reflow
                    dropdown.style.opacity = '1';
                    dropdown.style.transform = 'scale(1)';
                    isOpen = true;
                }

                function hideDropdown() {
                    dropdown.style.opacity = '0';
                    dropdown.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        dropdown.classList.add('hidden');
                    }, 200);
                    isOpen = false;
                }

                function toggleDropdown() {
                    if (isOpen) {
                        hideDropdown();
                    } else {
                        // Close other dropdowns first
                        containers.forEach(otherContainer => {
                            if (otherContainer !== container) {
                                const otherDropdown = otherContainer.querySelector('.js-dropdown-menu');
                                if (otherDropdown && !otherDropdown.classList.contains('hidden')) {
                                    otherDropdown.style.opacity = '0';
                                    otherDropdown.style.transform = 'scale(0.95)';
                                    setTimeout(() => {
                                        otherDropdown.classList.add('hidden');
                                    }, 200);
                                }
                            }
                        });
                        showDropdown();
                    }
                }

                // Toggle on trigger click
                trigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleDropdown();
                });

                // Close on outside click
                document.addEventListener('click', function(e) {
                    if (isOpen && !container.contains(e.target)) {
                        hideDropdown();
                    }
                });

                // Close on escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && isOpen) {
                        hideDropdown();
                    }
                });

                // Close when clicking on dropdown content links/buttons
                dropdown.addEventListener('click', function(e) {
                    if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON' || e.target.closest('a') || e.target.closest('button')) {
                        setTimeout(hideDropdown, 100);
                    }
                });
            });
        }

        // Initialize on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initDropdowns);
        } else {
            initDropdowns();
        }
    })();
</script>
