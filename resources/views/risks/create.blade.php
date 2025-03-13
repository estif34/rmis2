<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Risk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('risks.store') }}">
                        @csrf
                        
                        <!-- Basic Information Section -->
                        <div class="mb-10">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Basic Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Risk Title <span class="text-red-500">*</span></label>
                                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="risk_category_id" class="block text-sm font-medium text-gray-700 mb-1">Risk Category <span class="text-red-500">*</span></label>
                                    <select id="risk_category_id" name="risk_category_id" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('risk_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('risk_category_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="description" name="description" rows="4"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        
                        <!-- Risk Assessment Section -->
                        <div class="mb-10">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Risk Assessment</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Risk Level</label>
                                    <select id="level" name="level"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Select level</option>
                                        <option value="low" {{ old('level') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('level') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('level') == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="proximity" class="block text-sm font-medium text-gray-700 mb-1">Risk Proximity</label>
                                    <select id="proximity" name="proximity"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Select proximity</option>
                                        <option value="immediate" {{ old('proximity') == 'immediate' ? 'selected' : '' }}>Immediate</option>
                                        <option value="short_term" {{ old('proximity') == 'short_term' ? 'selected' : '' }}>Short-term</option>
                                        <option value="medium_term" {{ old('proximity') == 'medium_term' ? 'selected' : '' }}>Medium-term</option>
                                        <option value="long_term" {{ old('proximity') == 'long_term' ? 'selected' : '' }}>Long-term</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="likelihood" class="block text-sm font-medium text-gray-700 mb-1">Likelihood</label>
                                    <select id="likelihood" name="likelihood"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Select likelihood</option>
                                        <option value="very_low" {{ old('likelihood') == 'very_low' ? 'selected' : '' }}>Very Low</option>
                                        <option value="low" {{ old('likelihood') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('likelihood') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('likelihood') == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="very_high" {{ old('likelihood') == 'very_high' ? 'selected' : '' }}>Very High</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="risk_area" class="block text-sm font-medium text-gray-700 mb-1">Risk Area</label>
                                    <input type="text" id="risk_area" name="risk_area" value="{{ old('risk_area') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                    <select id="department" name="department"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Select department</option>
                                        @foreach ($departments as $dept)
                                            <option value="{{ $dept }}" {{ old('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Impact Details Section -->
                        <div class="mb-10">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Impact Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label for="impact_level" class="block text-sm font-medium text-gray-700 mb-1">Impact Level</label>
                                    <select id="impact_level" name="impact_level"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Select impact level</option>
                                        <option value="low" {{ old('impact_level') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('impact_level') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('impact_level') == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="severe" {{ old('impact_level') == 'severe' ? 'selected' : '' }}>Severe</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="impact_likelihood" class="block text-sm font-medium text-gray-700 mb-1">Impact Likelihood</label>
                                    <select id="impact_likelihood" name="impact_likelihood"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Select likelihood</option>
                                        <option value="very_low" {{ old('impact_likelihood') == 'very_low' ? 'selected' : '' }}>Very Low</option>
                                        <option value="low" {{ old('impact_likelihood') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('impact_likelihood') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('impact_likelihood') == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="very_high" {{ old('impact_likelihood') == 'very_high' ? 'selected' : '' }}>Very High</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="impact_proximity" class="block text-sm font-medium text-gray-700 mb-1">Impact Proximity</label>
                                    <select id="impact_proximity" name="impact_proximity"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Select proximity</option>
                                        <option value="immediate" {{ old('impact_proximity') == 'immediate' ? 'selected' : '' }}>Immediate</option>
                                        <option value="short_term" {{ old('impact_proximity') == 'short_term' ? 'selected' : '' }}>Short-term</option>
                                        <option value="medium_term" {{ old('impact_proximity') == 'medium_term' ? 'selected' : '' }}>Medium-term</option>
                                        <option value="long_term" {{ old('impact_proximity') == 'long_term' ? 'selected' : '' }}>Long-term</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label for="impact_description" class="block text-sm font-medium text-gray-700 mb-1">Impact Description</label>
                                <textarea id="impact_description" name="impact_description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('impact_description') }}</textarea>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label for="impact_type" class="block text-sm font-medium text-gray-700 mb-1">Impact Type</label>
                                    <select id="impact_type" name="impact_type"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Select impact type</option>
                                        <option value="financial" {{ old('impact_type') == 'financial' ? 'selected' : '' }}>Financial</option>
                                        <option value="operational" {{ old('impact_type') == 'operational' ? 'selected' : '' }}>Operational</option>
                                        <option value="reputational" {{ old('impact_type') == 'reputational' ? 'selected' : '' }}>Reputational</option>
                                        <option value="legal" {{ old('impact_type') == 'legal' ? 'selected' : '' }}>Legal</option>
                                        <option value="regulatory" {{ old('impact_type') == 'regulatory' ? 'selected' : '' }}>Regulatory</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="cause_of_impact" class="block text-sm font-medium text-gray-700 mb-1">Cause of Impact</label>
                                    <input type="text" id="cause_of_impact" name="cause_of_impact" value="{{ old('cause_of_impact') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="financial_impact" class="block text-sm font-medium text-gray-700 mb-1">Financial Impact ($)</label>
                                    <input type="number" id="financial_impact" name="financial_impact" step="0.01" value="{{ old('financial_impact') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mitigation Strategy Section -->
                        <div class="mb-10">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Mitigation Strategy</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="response_type" class="block text-sm font-medium text-gray-700 mb-1">Response Type</label>
                                    <select id="response_type" name="response_type"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Select response type</option>
                                        <option value="avoid" {{ old('response_type') == 'avoid' ? 'selected' : '' }}>Avoid</option>
                                        <option value="transfer" {{ old('response_type') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="mitigate" {{ old('response_type') == 'mitigate' ? 'selected' : '' }}>Mitigate</option>
                                        <option value="accept" {{ old('response_type') == 'accept' ? 'selected' : '' }}>Accept</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="mitigation_department" class="block text-sm font-medium text-gray-700 mb-1">Responsible Department</label>
                                    <select id="mitigation_department" name="mitigation_department"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Select department</option>
                                        @foreach ($departments as $dept)
                                            <option value="{{ $dept }}" {{ old('mitigation_department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label for="mitigation_strategy" class="block text-sm font-medium text-gray-700 mb-1">Mitigation Strategy</label>
                                <textarea id="mitigation_strategy" name="mitigation_strategy" rows="4"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('mitigation_strategy') }}</textarea>
                            </div>
                            
                            <div class="mb-6">
                                <label for="residual_risk" class="block text-sm font-medium text-gray-700 mb-1">Residual Risk</label>
                                <input type="text" id="residual_risk" name="residual_risk" value="{{ old('residual_risk') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('risks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                Cancel
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Create Risk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>