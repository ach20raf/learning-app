<template>
	<div class="bg-gray-200 w-full">
		<div
			class="bg-green-500 text-white rounded-l text-center transition-width duration-500"
			:style="'width:' + percent + '%;'"
		>
			{{ percent }}%
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return { watchedEpisodesData: this.watchedEpisodes };
		},
		props: ["watchedEpisodes", "episodes"],
		components: {},
		methods: {},
		mounted() {
			//console.log(this.watchedEpisodes, this.episodes);
			eventBus.$on("toggleProgress", (data) => (this.watchedEpisodesData = data));
		},
		computed: {
			percent() {
				return Math.ceil(
					(this.episodes.filter((ep) => {
						return this.watchedEpisodesData.find((wep) => {
							return wep.id == ep.id;
						});
					}).length /
						this.episodes.length) *
						100
				);
			},
		},
	};
</script>