<?php

namespace App\Services;

class Expense
{
    public $id;
    public $description;
    public $amount;
    public $createdAt;
    public $updatedAt;

    public function __construct($id, $description, $amount, $createdAt, $updatedAt)
    {
        $this->id = $id;
        $this->description = $description;
        $this->amount = $amount;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}

class ExpenseStorage
{
    private $file = 'data.json';
    private $data = [];

    public function __construct()
    {
        if (file_exists($this->file)) {
            $json = file_get_contents($this->file);
            $this->data = json_decode($json, true);
            $this->data = array_map(function ($expense) {
                return new Expense(...$expense);
            }, $this->data);
        }
    }

    public function addExpense($description, $amount)
    {
        $id = count($this->data) + 1;
        $date = date('Y-m-d H:i:s');
        $expense = new Expense($id, $description, $amount, $date, $date);
        $this->data[] = $expense;
        $this->saveToJson();

        return "Expense added successfully (ID: $id)";
    }

    public function listExpenses()
    {
        if (empty($this->data)) {
            return "No expenses found\n";
        }

        $output = "ID  Date       Description  Amount\n";
        foreach ($this->data as $expense) {
            $output .= sprintf(
                "%-3d %-10s %-12s $%-6s\n",
                $expense->id,
                date('Y-m-d', strtotime($expense->createdAt)),
                $expense->description,
                $expense->amount
            );
        }

        return $output;
    }

    public function summaryExpenses()
    {
        if (empty($this->data)) {
            return "No expenses found\n";
        }

        $total = 0;
        foreach ($this->data as $expense) {
            $total += $expense->amount;
        }

        return "Total expenses: $$total\n";
    }

    public function deleteExpenses($id)
    {
        // $this->data = array_filter($this->data, function ($expense) use ($id) {
        //     return $expense->id !== $id;
        // });
        // $this->saveToJson();

        foreach ($this->data as $key => $expense) {
            if ($expense->id == $id) {
                unset($this->data[$key]);
                $this->saveToJson();
                return "Expense deleted successfully\n";
            }
        }
    }

    public function saveToJson(): void
    {
        $data = array_map(function ($expense) {
            return [
                'id' => $expense->id,
                'description' => $expense->description,
                'amount' => $expense->amount,
                'createdAt' => $expense->createdAt,
                'updatedAt' => $expense->updatedAt,
            ];
        }, $this->data);

        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->file, $json);
    }

    public function saveToCsv(array $data): void
    {
        $fileHandle = fopen($this->file, 'a');
        fputcsv($fileHandle, $data);
        fclose($fileHandle);
    }
}
