<template>
	<app-layout>
		<template #header>
			{{ courseShow.title }}
		</template>
		<div class="py-4 mx-8">
			<div class="text-2xl mb-6">{{ episode.title }}</div>
			<iframe
				class="w-full h-screen"
				:src="episode.video_url"
				frameborder="0"
				allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
				allowfullscreen
			></iframe>
			<div class="py-6">
				<progress-bar
					:watchedEpisodes="watched"
					:episodes="courseShow.episodes"
				></progress-bar>
			</div>
			<div class="mt-6">
				<ul>
					<li
						class="mt-3 flex justify-between items-center"
						v-for="(ep, index) in courseShow.episodes"
						v-bind:key="ep.id"
					>
						<div>
							Episode nº{{ index + 1 }} - {{ ep.title }} -
							<button
								class="text-gray-500 focus:text-indigo-500 hover:text-blue-600 focus:outline-none"
								@click="switchEp(ep.id)"
							>
								Voir l'épisode
							</button>
						</div>
						<progress-button
							:episode_id="ep.id"
							:watchedEpisodes="watched"
						></progress-button>
					</li>
				</ul>
			</div>
		</div>
	</app-layout>
</template>
<script>
	import AppLayout from "./../../Layouts/AppLayout.vue";
	import ProgressButton from "./ProgressButton.vue";
	import ProgressBar from "./ProgressBar.vue";
	export default {
		components: {
			AppLayout,
			ProgressButton,
			ProgressBar,
		},
		props: ["course", "watched"],
		mounted() {},
		methods: {
			switchEp(id) {
				window.scrollTo({
					top: 0,
					left: 0,
					behavior: "smooth",
				});

				this.episode = this.courseShow.episodes.find((ep) => ep.id == id);
			},
		},
		data() {
			return {
				courseShow: this.course,
				episode: this.course.episodes[0],
			};
		},
	};
</script>