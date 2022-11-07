<div class="flex flex-col sm:flex-row gap-4 mt-4">
	<div class="sm:w-1/2">
		<!-- title -->
		<x-text-input
			class="block w-full"
			type="text"
			name="title"
			:label="__('Titel')"
			:value="old('title', isset($category) ? $category->title : null)"
			required
		/>
	</div>
	<div class="sm:w-1/2">
		<!-- description -->
		<x-text-input
			class="block w-full"
			type="text"
			name="description"
			:label="__('Beschreibung des Bereichs')"
			:value="old('description', isset($category) ? $category->description : null)"
			required
		/>
	</div>
</div>
