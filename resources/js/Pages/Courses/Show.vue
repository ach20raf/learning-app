<template>
	<app-layout>
		<template #header>
			{{ courseShow.title }}
		</template>
		<div v-if="courseShow.episodes.length > 0" class="py-4 mx-8">
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
		<div v-else>
			<div class="flex flex-col justify-center bg-grey-lighter">
				<div class="text-2xl text-gray-400 text-center bg-grey-light py-2 m-2">
					Description : {{ courseShow.description }}
				</div>
				<div
					class="text-grey-darker text-center bg-grey-light px-4 py-2 m-2"
				></div>
				<div
					class="text-6xl font-serif text-bold text-grey-darker text-center bg-grey-light px-4 py-2 m-2"
				>
					No episode found
				</div>
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
		mounted() {
			console.log(this.course);
		},
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