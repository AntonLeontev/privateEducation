@props([
	'device',
	'sound',
])

<div class="flex flex-col items-center cursor-pointer" @click="$refs.file.click()" x-data="file_{{ $sound }}_{{ $device }}">
    <input 
		type="file"
		class="hidden" 
		:name="page === 'audio' ? 'audio' : 'video'"
		:accept="page === 'audio' ? 'audio/*' : 'video/*'" 
		@change="upload"
		x-ref="file"
	>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :fill="page == 'video' ? '#1ba5e2' : '#f7729a'" width="40" x-show="exists()" >
        <path fill-rule="evenodd"
            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
            clip-rule="evenodd" />
    </svg>

	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#78f772" width="40" x-show="!exists()" x-cloak>
		<path fill-rule="evenodd"
			d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
			clip-rule="evenodd" />
	</svg>

    <button :class="page != 'audio' && 'text-[#f8fe58]'" x-text="exists() ? 'Сменить' : 'Загрузить'">
        Сменить
    </button>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('file_{{ $sound }}_{{ $device }}', () => ({
			sound: '{{ $sound }}',
			device: '{{ $device }}',

			upload() {
				let data = new FormData()

				this.page === 'audio' 
					? data.append('audio', this.$refs.file.files[0])
					: data.append('video', this.$refs.file.files[0])

				data.append('lang', this.lang)
				data.append('sound', this.sound)
				data.append('device', this.device)
				data.append('type', this.page)
				data.append('fragment_id', this.selectedFragment.id)
				
				this.progressbar = true

				axios
					.postForm(
						route('admin.media.store'), 
						data, 
						{onUploadProgress: (e) => {
							this.progress = e.progress
						}}
					)
					.then(response => {
						let media = this.findMedia()

						if (!media) {
							this.selectedFragment[this.page].media.push(response.data)
							return
						}

						let index = this.selectedFragment[this.page].media.indexOf(media)
						this.selectedFragment[this.page].media[index] = response.data
					})
					.catch(error => {
						console.log(error);
						axios.post(route('error.watch', {test: true, error: error}));
						alert('Ошибка загрузки')
					})
					.finally(() => {
						setTimeout(() => {
							this.progressbar = false
						}, 500);
					})
			},
			exists() {
				let media = this.findMedia()

				return media != null
			},
			findMedia() {
				if (this.page === 'text') return
				
				return this.selectedFragment[this.page].media.find(el => {
					if (el.lang !== this.lang) return false
					if (el.sound !== this.sound) return false
					if (el.device !== this.device) return false

					return true
				})
			},
		}))
	})
</script>
