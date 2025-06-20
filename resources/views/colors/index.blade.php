<x-layouts.app :title="'Manage Colors - ' . $product->productName">
    <div class="p-8 space-y-8">

<div class="flex flex-col md:flex-row items-center md:items-start gap-6 p-6 bg-white dark:bg-zinc-800 rounded-2xl  shadow-sm">

  {{-- Product Image --}} 
  <div class="flex w-full items-center gap-6 rounded-xl bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 shadow-sm p-6">
            @php
                $images = json_decode($product->image_url, true);
            @endphp
             @foreach($images as $image)
                <div class="overflow-hidden rounded-sm border border-gray-200 dark:border-zinc-700">
                    <img src="{{ asset('storage/' . $image) }}" alt="Product Image" class="h-50 object-cover" style="width: 200px;"/>
                </div>
            @endforeach

   {{-- Product Info --}}
    <div class="flex-1  md:text-left space-y-1">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $product->productName }}</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $product->category }}</p>
        <p class="text-sm text-gray-600 dark:text-gray-300">Size: {{ $product->sizes }}</p>
        <p class="text-sm text-gray-600 dark:text-gray-300">Price: <span class="font-medium text-blue-600 dark:text-blue-400">RM{{ $product->min_price }} - RM{{ $product->max_price }}</span></p>

    {{-- Add Color Button --}}
    <div class="mt-4 md:mt-0">
        <flux:modal.trigger name="add-color">
            <flux:button variant="primary" icon="plus">Add Color</flux:button>
        </flux:modal.trigger>
    </div>
    </div>
  </div>
</div>

    {{-- Add Color Modal --}}
    <flux:modal name="add-color">
        <div class="p-6 space-y-6">
            <!-- Modal Title -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Add New Color</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Fill in the color details and pricing for multiple sizes.</p>
            </div>

            <!-- Form Start -->
            <form method="POST" action="{{ route('colors.store', ['product' => $product->id]) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('POST')
                    
                <!-- Basic Color Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input label="Color Name" name="color_name" required />
                        <flux:input label="Color Code (e.g. #ff0000)" name="color_code" required />
                        <flux:input type="file" wire:model="attachments" label="Color Pallet" name="color_pallet" required />
                    </div>

                <!-- Dynamic Size & Price Inputs -->
                    <div 
                        x-data="{
                            sizes: [{ litre: '', price: '' }],
                            remove(index) {
                                if (this.sizes.length > 1) this.sizes.splice(index, 1);
                            }
                        }"
                        class="space-y-4 border border-gray-200 dark:border-zinc-700 p-4 rounded-xl bg-gray-50 dark:bg-zinc-800"
                    >
                        <div class="flex justify-between items-center">
                            <h3 class="text-md font-semibold text-gray-700 dark:text-white">Litre & Price Options</h3>
                        
                        </div>

                        <template x-for="(size, index) in sizes" :key="index">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end relative">
                                <div class="relative mt-2" >

                                    
                                    <!-- Per-row remove button -->
                                    <div class="absolute top-0 right-0 mt-1.5 mr-1 mb-2 text-xs text-red-500 hover:text-red-700">
                                    <flux:button icon="x-mark" variant="subtle"
                                        type="button"
                                        @click="remove(index)"
                                        x-show="sizes.length > 1"
                                    >
                                        
                                    </flux:button>
                                </div>

                                    <flux:input 
                                        :label="'Litre (L)'" 
                                        :name="'litres[]'" 
                                        x-model="size.litre" 
                                        type="number" 
                                        step="0.01"
                                        class="mb-2" 
                                        required 
                                    />
                        
                                    <flux:input 
                                        :label="'Price (RM)'" 
                                        :name="'prices[]'" 
                                        x-model="size.price" 
                                        type="number" 
                                        step="0.01" 
                                        class="mb-2" 
                                        required 
                                    /> 

                            </div>
                                <flux:separator /> 
                            </div>
                        </template>
                        <div class="mt-4" >
                        <flux:button 
                                type="button" 
                                variant="subtle" 
                                class="text-sm" 
                                @click="sizes.push({ litre: '', price: '' })" >
                                + Add Size
                            </flux:button>
                        </div>
                    </div>


                    <!-- Submit Button -->
                    <div class="flex justify-end pt-2">
                        <flux:button type="submit" variant="primary">Save Color</flux:button>
                    </div>
                </form>
            </div>
        </flux:modal>


        <!-- Main Content Grid -->
        <div class="space-y-6">
            <div class="flex justify-between items-center mt-6">
                <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Available Colors</h3>
                <div class="flex items-center gap-4">
                    <div class="relative">
                          <!-- Search and Filter Form -->
            <form action="{{ route('inventory.search') }}" method="GET" class="flex flex-wrap items-center gap-4 justify-end">
                
                <!-- Category Dropdown -->
                <div class="relative">
                    
                </div>

                <!-- Search Input -->
                <div class="flex-1 min-w-xs">
                    <flux:input name="search" placeholder="Search products..." />
                </div>

                <!-- Search Button -->
                <div>
                    <flux:button icon="magnifying-glass" type="submit" variant="primary">
                        <span class="hidden sm:inline">Search</span>
                    </flux:button>
                </div>

            </form>
                    </div>
                 
                </div>
            </div>


<div 
 class="overflow-x-auto rounded-xl shadow-md border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
  <table class="min-w-full w-full divide-y divide-gray-200 dark:divide-zinc-700 text-sm text-center">
        <thead class="bg-gray-100 dark:bg-zinc-700 text-gray-700 dark:text-gray-300">
            <tr>
                <th class="px-4 py-3 text-left">
                        <input type="checkbox"
                            x-model="selectAll"
                            @change="toggleAll"
                            :indeterminate="isIndeterminate()"
                            x-init="updateMasterCheckbox($el)">
                    </th>
                <th class="px-4 py-3 text-left">Color</th>
                <th class="px-4 py-3 text-left">Code</th>
                <th class="px-4 py-3 text-left">Preview</th>
                <th class="px-4 py-3 text-left">Litres</th>
                <th class="px-4 py-3 text-left relative">Price</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
            <tr>
                {{-- Bulk Actions Bar --}}
                <x-color.bulk-action-bar
                    :product-id="$product->id"
                    :color-ids="$product->colors->pluck('id')->toArray()"
                />
            </tr>   
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">
            @foreach($colors as $color)
                <tr>
                    <td>
                        <div class="items-center justify-center">
                        <input type="checkbox"
                            value="{{ $color->id }}"
                            x-model="selected"
                            @change="checkSelectAll">
                        </div>
                    </td>

                    {{-- Color Name --}}
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                        {{ $color->color_name }}
                    </td>

                    {{-- Color Code --}}
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        {{ $color->color_code }}
                    </td>

                   {{-- Preview Box --}}
                    <td class="px-4 py-3 flex justify-center items-center">
                        <div class="h-10 rounded-full border border-gray-300 dark:border-zinc-600"
                            style="width: 300px; background-image: url('{{ asset('storage/' . $color->color_pallet) }}'); background-size: cover;">
                        </div>
                    </td>

                    {{-- Litres & Prices --}}
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        <div class="space-y-1">
                            @foreach($color->litres as $litre)
                                <div>
                                    <span>{{ $litre->litre }} L</span>
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        <div class="space-y-1">
                            @foreach($color->litres as $litre)
                                <div>
                                    <span class="font-semibold">RM{{ number_format($litre->price, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </td>

                    {{-- Edit/Delete --}}
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href=""
                           class="inline-block text-blue-600 hover:underline mr-3">
                            Edit
                        </a>

                        <form action=""
                              method="POST" class="inline-block"
                              onsubmit="return confirm('Are you sure you want to delete this color?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- For Debugging -->
    <p class="text-sm mt-2">Selected: <span x-text="JSON.stringify(selected)"></span></p>

</div>
 </div>
</div>
<script>
    function priceManager(allIds, deleteUrl, adjustPriceUrl) {
    return {
        all: allIds, // define it here
        selected: [],
        selectAll: false,
        deleteUrl,
        adjustPriceUrl,

        toggleAll() {
            if (this.selectAll) {
                this.selected = [...this.all];
            } else {
                this.selected = [];
            }
        },

        checkSelectAll() {
            this.selectAll = this.all.every(id => this.selected.includes(id.toString()));
        },

        isIndeterminate() {
            return this.selected.length > 0 && this.selected.length < this.all.length;
        },

        updateMasterCheckbox(el) {
            el.indeterminate = this.isIndeterminate();
        },

        openAdjustModal() {
            this.$refs.adjustModal.showModal();
        }
    };
}
</script>

</x-layouts.app>
