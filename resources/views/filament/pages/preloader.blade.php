<div>
    <div
        x-transition.opacity
        class="preloader fixed inset-0 z-50 flex items-center justify-center bg-white/70 dark:bg-gray-900/70">
        <div class="bg-gray-500/50 absolute inset-0 z-50">
            <div class="flex items-center justify-center w-screen h-screen">
                <img src="{{ url('assets/loading.gif') }}" alt="Loading...">
            </div>
        </div>
    </div>

    @script
    <script data-navigate-once>
        Livewire.on('preloader', ({
            postId
        }) => {
            setTimeout(() => {
                document.querySelector('.preloader').style.display = 'none';
            }, 500)
        }, {
            once: true
        });

        document.addEventListener('livewire:navigate', (event) => {
            document.querySelector('.preloader').style.display = 'block';
        })
        document.addEventListener('livewire:navigated', () => {
            setTimeout(() => {
                document.querySelector('.preloader').style.display = 'none';
            }, 500)
        })
    </script>
    @endscript

</div>