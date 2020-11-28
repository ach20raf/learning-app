<template>
	<app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Modification de {{ courseEdit.title }}
			</h2>
		</template>

		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-green-200 text-green-500 p-3" v-if="$page.flash.success">
					{{ $page.flash.success }}
				</div>
				<form
					class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
					@submit.prevent="submit"
				>
					<div class="mb-4">
						<label
							class="block text-gray-700 text-sm font-bold mb-2"
							for="title"
						>
							Titre de la formation
						</label>
						<input
							class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
							id="title"
							type="text"
							placeholder="Title"
							v-model="courseEdit.title"
						/>
						<div
							class="alert bg-red-400 text-white m-2 rounded pl-5"
							v-if="$page.errors.title"
						>
							<ul>
								<li v-for="(err, ind) in $page.errors.title" v-bind:key="ind">
									{{ err }}
								</li>
							</ul>
						</div>
					</div>
					<div class="mb-4">
						<label
							class="block text-gray-700 text-sm font-bold mb-2"
							for="description"
						>
							Description de la formation
						</label>
						<textarea
							class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
							id="description"
							type="text"
							placeholder="Description"
							v-model="courseEdit.description"
						></textarea>
						<div
							class="alert bg-red-400 text-white m-2 rounded pl-5"
							v-if="$page.errors.description"
						>
							<ul>
								<li
									v-for="(err, ind) in $page.errors.description"
									v-bind:key="ind"
								>
									{{ err }}
								</li>
							</ul>
						</div>
					</div>
					<div class="mb-4">
						<h2 class="text-3xl">Episodes de la formation</h2>
						<div
							class="border border-gray-400 border-2 p-4 rounded m-2 mb-5 shadow-inner"
							v-for="(epi, index) in courseEdit.episodes"
							v-bind:key="index"
						>
							<div class="mb-4">
								<label
									class="block text-gray-700 text-sm font-bold mb-2"
									:for="'title' + index"
								>
									Titre de l'épisode nº {{ index + 1 }}
								</label>
								<input
									class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
									:id="'title' + index"
									type="text"
									placeholder="Title"
									v-model="courseEdit.episodes[index].title"
								/>
								<div
									class="alert bg-red-400 text-white m-2 rounded pl-5"
									v-if="$page.errors['episodes.' + index + '.title']"
								>
									<ul>
										<li
											v-for="(err, ind) in $page.errors[
												'episodes.' + index + '.title'
											]"
											v-bind:key="ind"
										>
											{{ err }}
										</li>
									</ul>
								</div>
							</div>
							<div class="mb-4">
								<label
									class="block text-gray-700 text-sm font-bold mb-2"
									:for="'description' + index"
								>
									Description de l'épisode nº {{ index + 1 }}
								</label>
								<input
									class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
									:id="'description' + index"
									type="text"
									placeholder="Description"
									v-model="courseEdit.episodes[index].description"
								/>
								<div
									class="alert bg-red-400 text-white m-2 rounded pl-5"
									v-if="$page.errors['episodes.' + index + '.description']"
								>
									<ul>
										<li
											v-for="(err, ind) in $page.errors[
												'episodes.' + index + '.description'
											]"
											v-bind:key="ind"
										>
											{{ err }}
										</li>
									</ul>
								</div>
							</div>
							<div class="mb-4">
								<label
									class="block text-gray-700 text-sm font-bold mb-2"
									:for="'video_url' + index"
								>
									Url de la video de l'épisode nº {{ index + 1 }}
								</label>
								<input
									class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
									:id="'video_url' + index"
									type="text"
									placeholder="Video Url"
									v-model="courseEdit.episodes[index].video_url"
								/>
								<div
									class="alert bg-red-400 text-white m-2 rounded pl-5"
									v-if="$page.errors['episodes.' + index + '.video_url']"
								>
									<ul>
										<li
											v-for="(err, ind) in $page.errors[
												'episodes.' + index + '.video_url'
											]"
											v-bind:key="ind"
										>
											{{ err }}
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="mb-4">
							<button
								class="px-4 py-2 bg-green-600 rounded my-2 text-white block"
								@click.prevent="add"
								v-if="courseEdit.episodes.length < 15"
							>
								➕
							</button>
							<button
								class="px-4 py-2 bg-red-600 rounded my-2 text-white block"
								@click.prevent="remove"
								v-if="courseEdit.episodes.length > 0"
							>
								🗑️
							</button>
						</div>
					</div>

					<button
						class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
						type="submit"
					>
						Modifier ma formation
					</button>
				</form>
			</div>
		</div>
	</app-layout>
</template>

<script>
	import AppLayout from "@/Layouts/AppLayout";

	export default {
		components: {
			AppLayout,
		},
		props: ["course"],
		data() {
			return { courseEdit: this.course };
		},
		methods: {
			submit() {
				this.$inertia.patch(`/courses/${this.courseEdit.id}`, this.courseEdit);
			},
			add() {
				this.courseEdit.episodes.push({
					title: null,
					description: null,
					video_url: null,
				});
			},
			remove() {
				this.courseEdit.episodes.pop();
			},
		},
	};
</script>
