<div class="flex gap-4">
  <!-- active -->
  <x-checkbox-input
    for="active"
    :label="__('Aktiv')"
    class="w-1/2"
  />
  <!-- separateAccounting -->
  <x-checkbox-input
    for="separateAccounting"
    :label="__('Getrennte Abrechnung')"
    class="w-1/2"
  />
</div>

<div class="flex gap-4 mt-4">
  <!-- date (no time needed) -->
  <x-text-input
    class="block w-1/2"
    type="date"
    name="start"
    :value="old('start')"
    :label="__('Datum Einstieg')"
    required
  />
  <!-- hours -->
  <x-text-input
    class="block w-1/2"
    type="number"
    name="targetHours"
    :value="old('targetHours')"
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
      :value="old('firstname1')"
      :label="__('Vorname')"
      required
    />
    <!-- 1. lastname -->
    <x-text-input
      class="mt-4 block w-full"
      type="text"
      name="lastname1"
      :value="old('lastname1')"
      :label="__('Nachname')"
      required
    />
    <!-- 1. email -->
    <x-text-input
      class="mt-4 block w-full"
      type="email"
      name="email1"
      :value="old('email1')"
      :label="__('E-Mail-Adresse')"
      required
    />
    <!-- 1. isAdmin -->
    <x-checkbox-input
      for="isAdmin1"
      :label="__('Administrator')"
      class="mt-4"
    />
  </div>

  <!-- second person -->
  <div class="w-1/2">
    <h3>2. Person</h3>
    <!-- 2. firstname -->
    <x-text-input
      class="mt-4 block w-full"
      type="text"
      name="firstname2"
      :value="old('firstname1')"
      :label="__('Vorname')"
      required
    />
    <!-- 2. lastname -->
    <x-text-input
      class="mt-4 block w-full"
      type="text"
      name="lastname2"
      :value="old('lastname1')"
      :label="__('Nachname')"
      required
    />
    <!-- 2. email -->
    <x-text-input
      class="mt-4 block w-full"
      type="email"
      name="email2"
      :value="old('email1')"
      :label="__('E-Mail-Adresse')"
      required
    />
    <!-- 2. isAdmin -->
    <x-checkbox-input
      for="isAdmin2"
      :label="__('Administrator')"
      class="mt-4"
    />
  </div>
</div>
