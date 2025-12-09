<x-mail::message>
# 🎓 Reminder Jadwal 

Halo {{ $student->name }},  
Kamu mengaktifkan pengingat untuk jadwal di GoPTN.

Berikut Jadwal {{ $item->name }}:

---

### 📌 {{ $item->name }}
- 🕒 Timeline: **{{ $item->start_date }} - {{ $item->end_date ?? 'Belum ditentukan' }}**
- ⏳ Status: **{{ ucfirst($item->status) }}**

---

<x-mail::button :url="'https://goptn.siunjaya.id'">
Lihat Detail di GoPTN
</x-mail::button>

Terus pantau jadwalmu agar tidak terlewat.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
