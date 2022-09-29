<div class="flex gap-4">
  <!-- active -->
  <x-checkbox-input
    name="active"
    class="w-1/2"
    :label="__('Aktiv')"
    :checked="old('active', isset($account) ? $account->active : false)"
  />
  <!-- separate_accounting -->
  <x-checkbox-input
    name="separate_accounting"
    class="w-1/2"
    :label="__('Getrennte Abrechnung')"
    :checked="old('separate_accounting', isset($account) ? $account->separate_accounting : false)"
  />
</div>

<div class="flex gap-4 mt-4">
  <!-- date (no time needed) -->
  <x-text-input
    class="block w-1/2"
    type="date"
    name="start"
    :value="old('start', isset($account) ? date('Y-m-d', strtotime($account->start)) : null)"
    :label="__('Datum Einstieg')"
    required
  />
  <!-- hours -->
  <x-text-input
    class="block w-1/2"
    type="number"
    name="target_hours"
    :value="old('target_hours', isset($account) ? $account->target_hours : null)"
    :label="__('Abweichende Mindestanzahl Pflichtstunden')"
    required
  />
</div>

<div class="mt-4 flex gap-4">
  <!-- first person -->
  <div class="w-1/2">
    <h3>1. Person</h3>
    <!-- 1. firstname -->
    <x-text-input
      class="mt-4 block w-full"
      type="text"
      name="firstname1"
      :value="old('firstname1', isset($account) ? $account->users[0]->firstname : null)"
      :label="__('Vorname')"
      required
    />
    <!-- 1. lastname -->
    <x-text-input
      class="mt-4 block w-full"
      type="text"
      name="lastname1"
      :value="old('lastname1', isset($account) ? $account->users[0]->lastname : null)"
      :label="__('Nachname')"
      required
    />
    <!-- 1. email -->
    <x-text-input
      class="mt-4 block w-full"
      type="email"
      name="email1"
      :value="old('email1', isset($account) ? $account->users[0]->email : null)"
      :label="__('E-Mail-Adresse')"
      required
    />
    <!-- 1. is_admin -->
    <x-checkbox-input
      name="is_admin1"
      class="block mt-4"
      :label="__('Administrator')"
      :checked="old('is_admin1', isset($account) ? $account->users[0]->is_admin : false)"
    />
  </div>

  <!-- second person -->
  <div class="w-1/2">
    <h3>2. Person (optional)</h3>
    <!-- 2. firstname -->
    <x-text-input
      class="mt-4 block w-full"
      type="text"
      name="firstname2"
      :value="old('firstname2', isset($account) && isset($account->users[1]) ? $account->users[1]->firstname : null)"
      :label="__('Vorname')"
    />
    <!-- 2. lastname -->
    <x-text-input
      class="mt-4 block w-full"
      type="text"
      name="lastname2"
      :value="old('lastname2', isset($account) && isset($account->users[1]) ? $account->users[1]->lastname : null)"
      :label="__('Nachname')"
    />
    <!-- 2. email -->
    <x-text-input
      class="mt-4 block w-full"
      type="email"
      name="email2"
      :value="old('email2', isset($account) && isset($account->users[1]) ? $account->users[1]->email : null)"
      :label="__('E-Mail-Adresse')"
    />
    <!-- 2. is_admin -->
    <x-checkbox-input
      name="is_admin2"
      class="block mt-4"
      :label="__('Administrator')"
      :checked="old('is_admin2', isset($account) && isset($account->users[1]) ? $account->users[1]->is_admin : false)"
    />
  </div>
</div>
