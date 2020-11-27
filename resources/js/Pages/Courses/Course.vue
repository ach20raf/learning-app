<template>
	<div class="mx-8 p-4 bg-white rounded shadow">
		<div class="text-sm text-gray-500">
			Mise en ligne par {{ courseItem.user.name }} -
			<span class="text-gray-500 text-sm">
				{{ course.participants }} Participant<span
					v-if="parseInt(course.participants) > 1"
					>s</span
				>
			</span>
		</div>
		<div class="flex justify-between items-center">
			<div class="text-4xl">{{ courseItem.title }}</div>
			<div class="text-sm text-gray-400">
				{{ courseItem.episodes_count }} episodes
			</div>
		</div>

		<div class="text-sm text-gray-500">{{ courseItem.description }}</div>
		<a
			class="bg-indigo-500 text-white px-2 py-1 mt-3 text-sm rounded hover:bg-indigo-800 inline-block"
			:href="'course/' + courseItem.id"
			>Voir la formation</a
		>
	</div>
</template>
<script>
	export default {
		data() {
			return { courseItem: this.course };
		},
		props: ["course"],
		mounted() {
			//console.log(this.course.title, this.course.id, this.course.participants);
		},
	};
</script>