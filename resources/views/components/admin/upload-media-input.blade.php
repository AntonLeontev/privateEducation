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

			async upload() {
				const file = this.$refs.file.files[0]
				if (!file) {
					return
				}

				const maxFileSize = {{ (int) config('media.max_file_size') }}
				if (file.size > maxFileSize) {
					alert('Файл больше {{ (int) config("media.max_file_size") / 1024 / 1024 / 1024 }} ГБ')
					return
				}

				this.progressbar = true
				this.progress = 0

				try {
					const init = await axios.post(route('admin.media.uploads.init'), {
						lang: this.lang,
						sound: this.sound,
						device: this.device,
						type: this.page,
						fragment_id: this.selectedFragment.id,
						size: file.size,
					})

					const uploadId = init.data.upload_id
					const chunkSize = init.data.chunk_size
					const totalChunks = Math.ceil(file.size / chunkSize)

					for (let index = 0; index < totalChunks; index++) {
						const start = index * chunkSize
						const blob = file.slice(start, start + chunkSize)
						await this.postChunk(uploadId, index, blob, file.name, totalChunks)
					}

					const response = await axios.post(
						route('admin.media.uploads.complete', { upload: uploadId })
					)

					this.applyUploadedMedia(response.data)
				} catch (error) {
					axios.post(route('error.watch', {test: true, error: error}))
					alert(this.uploadErrorMessage(error))
				} finally {
					setTimeout(() => {
						this.progressbar = false
					}, 500)
				}
			},
			uploadErrorMessage(error) {
				if (!error.response) {
					return 'Связь оборвалась. Попробуйте ещё раз'
				}

				const status = error.response.status
				const reason = error.response.data?.reason
				const url = String(error.config?.url || '')

				if (reason === 'size' || status === 413) {
					if (url.includes('/chunks')) {
						return 'Слишком большой фрагмент файла'
					}

					return 'Файл больше 2 ГБ'
				}

				if (reason === 'incomplete' || url.includes('/complete')) {
					return 'Не удалось собрать файл'
				}

				return 'Ошибка загрузки'
			},
			async postChunk(uploadId, index, blob, fileName, totalChunks) {
				let lastError = null

				for (let attempt = 1; attempt <= 3; attempt++) {
					try {
						const data = new FormData()
						data.append('index', index)
						data.append('chunk', blob, fileName)

						await axios.post(
							route('admin.media.uploads.chunks', { upload: uploadId }),
							data,
							{
								onUploadProgress: (event) => {
									const chunkProgress = event.progress ?? 0
									this.progress = (index + chunkProgress) / totalChunks
								},
							}
						)

						this.progress = (index + 1) / totalChunks
						return
					} catch (error) {
						lastError = error
						const status = error.response?.status
						const canRetry = !error.response || (status >= 500 && status < 600)

						if (!canRetry || attempt === 3) {
							throw error
						}
					}
				}

				throw lastError
			},
			applyUploadedMedia(uploaded) {
				const media = this.findMedia()

				if (!media) {
					this.selectedFragment[this.page].media.push(uploaded)
					return
				}

				const mediaIndex = this.selectedFragment[this.page].media.indexOf(media)
				this.selectedFragment[this.page].media[mediaIndex] = uploaded
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
