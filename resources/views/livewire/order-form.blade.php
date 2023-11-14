<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $editing ? 'Edit Order' : 'Create Order' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <form wire:submit.prevent="save" class="flex justify-between">
                        <div>
                            <label for="cars">Select Status Of Order:</label>
                            <select id="status" name="order[status]" wire:model="order.status" class="px-8 py-2 ml-1 border border-transparent bg-gray-800 text-white text-xs uppercase rounded-md cursor-pointer font-semibold text-opacity-90 tracking-wider">
                                <option value="0">Payment Received</option>
                                <option value="1">Shipping</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 mr-2 border border-transparent bg-gray-800 text-white text-xs uppercase rounded-md cursor-pointer font-semibold text-opacity-90 tracking-wider">Submit</button>
                        </div>
                    </form>
                    <!-- <form wire:submit.prevent="save">
                        @csrf

                        <div>
                            <x-input-label class="mb-1" for="country" :value="__('Customer')" />

                            <x-select2 class="mt-1" id="country" name="country" :options="$this->listsForFields['users']" wire:model="order.user_id" />
                            <x-input-error :messages="$errors->get('order.user_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label class="mb-1" for="order_date" :value="__('Order date')" />

                            <input x-data
                                     x-init="new Pikaday({ field: $el, format: 'MM/DD/YYYY' })"
                                     type="text"
                                     id="order_date"
                                     wire:model.lazy="order.order_date"
                                     autocomplete="off"
                                     class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                            <x-input-error :messages="$errors->get('order.order_date')" class="mt-2" />
                        </div>

                        {{-- Order Products --}}
                        <table class="mt-4 min-w-full border divide-y divide-gray-200">
                            <thead>
                                <th class="px-6 py-3 text-left bg-gray-50">
                                    <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Product</span>
                                </th>
                                <th class="px-6 py-3 text-left bg-gray-50">
                                    <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Quantity</span>
                                </th>
                                <th class="px-6 py-3 w-56 text-left bg-gray-50"></th>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                <tr>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        Product Name
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        Product Price
                                    </td>
                                    <td>
                                        <x-primary-button>
                                            Edit
                                        </x-primary-button>
                                        <button class="px-4 py-2 ml-1 text-xs text-red-500 uppercase bg-red-200 rounded-md border border-transparent hover:text-red-700 hover:bg-red-300">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <x-primary-button wire:click.prevent="addProduct">+ Add Product</x-primary-button>
                            <select id="status" name="order[status]" wire:model="order.status" class="px-8 py-2 ml-1 border border-transparent hover: bg-gray-800 text-white text-xs uppercase rounded-md cursor-pointer font-semibold text-opacity-90 tracking-wider">
                                <option value="payment_received" >Payment Received</option>
                                <option value="shipping">Shipping</option>
                            </select>
                        </div>
                        {{-- End Order Products --}}

                        <div class="flex justify-end">
                            <table>
                                @forelse($orderProducts as $index => $orderProduct)
                                    <tr>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @if($orderProduct['is_saved'])
                                                <input type="hidden" name="orderProducts[{{$index}}][product_id]" wire:model="orderProducts.{{$index}}.product_id" />
                                                @if($orderProduct['product_name'] && $orderProduct['product_price'])
                                                    {{ $orderProduct['product_name'] }}
                                                    (${{ number_format($orderProduct['product_price'] / 100, 2) }})
                                                @endif
                                            @else
                                                <select name="orderProducts[{{ $index }}][product_id]" class="focus:outline-none w-full border {{ $errors->has('$orderProducts.' . $index) ? 'border-red-500' : 'border-indigo-500' }} rounded-md p-1" wire:model="orderProducts.{{ $index }}.product_id">
                                                    <option value="">-- choose product --</option>
                                                    @foreach ($this->allProducts as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->name }}
                                                            (${{ number_format($product->price / 100, 2) }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('orderProducts.' . $index)
                                                    <em class="text-sm text-red-500">
                                                        {{ $message }}
                                                    </em>
                                                @enderror
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @if($orderProduct['is_saved'])
                                                <input type="hidden" name="orderProducts[{{$index}}][quantity]" wire:model="orderProducts.{{$index}}.quantity" />
                                                {{ $orderProduct['quantity'] }}
                                            @else
                                                <input type="number" step="1" name="orderProducts[{{$index}}][quantity]" class="p-1 w-full rounded-md border border-indigo-500 focus:outline-none" wire:model="orderProducts.{{$index}}.quantity" />
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @if($orderProduct['is_saved'])
                                                <x-primary-button wire:click.prevent="editProduct({{$index}})">
                                                    Edit
                                                </x-primary-button>
                                            @elseif($orderProduct['product_id'])
                                                <x-primary-button wire:click.prevent="saveProduct({{$index}})">
                                                    Save
                                                </x-primary-button>
                                            @endif
                                            <button class="px-4 py-2 ml-1 text-xs text-red-500 uppercase bg-red-200 rounded-md border border-transparent hover:text-red-700 hover:bg-red-300" wire:click.prevent="removeProduct({{$index}})">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            Start adding products to order.
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>

                        <div class="mt-4">
                            <x-primary-button type="submit">
                                Save
                            </x-primary-button>
                        </div>
                    </form> -->

                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
@endpush
