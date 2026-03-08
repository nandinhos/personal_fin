<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class QuickTransactionForm extends Component
{
    public $accountId;
    public $showModal = false;
    
    public $type = 'expense';
    public $amount = '';
    public $description = '';
    public $date = '';
    public $category_id = '';

    public function rules()
    {
        return [
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    #[On('quick-transaction-open')]
    public function openModal()
    {
        $this->reset(['type', 'amount', 'description', 'category_id']);
        $this->date = now()->format('Y-m-d');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $validatedData = $this->validate();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        
        $account = Account::findOrFail($this->accountId);

        if ($account->profile_id !== $user->currentProfile()->id) {
            abort(403);
        }

        // Criar transação
        Transaction::create([
            'profile_id' => $user->currentProfile()->id,
            'account_id' => $this->accountId,
            'category_id' => $this->category_id ?: null,
            'type' => $this->type,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => $this->date,
        ]);

        // Atualizar saldo de forma robusta
        $account->recalculateBalance();

        session()->flash('success', 'Lançamento registrado com sucesso!');
        
        $this->closeModal();
        $this->dispatch('account-saved'); // Atualiza a tela da conta
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $categories = Category::where('profile_id', $user->currentProfile()->id)
            ->where('type', $this->type)
            ->orderBy('name')
            ->get();

        return view('livewire.quick-transaction-form', [
            'categories' => $categories
        ]);
    }
}
