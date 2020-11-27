<template>
	<div>
		<button
			class="bg-green-500 px-2 py-3 text-white text-center rounded"
			@click="toggleProgress()"
		>
			Terminé {{ isWatched ? "" : "?" }}
		</button>
	</div>
</template>
<script>
	export default {
		props: ["episode_id", "watchedEpisodes"],
		methods: {
			toggleProgress() {
				axios
					.post("/toggleProgress", {
						episode_id: this.episode_id,
					})
					.then((response) => {
						if (response.status == 200) {
							this.isWatched = !this.isWatched;
							eventBus.$emit("toggleProgress", response.data);
						}
						console.log(response.data);
						this.watchedEp = response.data;
					})
					.catch((error) => {
						console.error(error);
					});
			},
			isWatchedEpisode() {
				//console.log(this.watchedEp);
				return this.watchedEp.find((el) => el.id == this.episode_id)
					? true
					: false;
			},
		},
		data() {
			return {
				watchedEp: this.watchedEpisodes,
				isWatched: null,
			};
		},
		mounted() {
			this.isWatched = this.isWatchedEpisode();
			//console.log(this.isWatched, this.episode_id);
		},
	};
</script>