@extends('layouts.main')

@section('container')
<div class="flex flex-auto flex-col">

    <div class="grid xl:grid-cols-3 gap-6">
        <div class="xl:col-span-3">
            <div class="card">
                <div class="border-b p-4 dark:border-gray-600">
                    <h6 class="uppercase dark:text-gray-300">Ulasan Pekerjaan/Kontrak</h6>
                </div>

                <div class="p-6">
                    <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6">
                        <!-- stat 1 -->
                        <div class="flex items-center gap-5">
                            <i data-lucide="calendar-check" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                            <div>
                                <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">{{ $kontrak->tgl_mulai_f }}</h4>
                                <span class="text-sm dark:text-gray-400">Tanggal Mulai</span>
                            </div>
                        </div>

                        <!-- stat 2 -->
                        <div class="flex items-center gap-5">
                            <i data-lucide="alarm-check" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                            <div>
                                <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">{{ $kontrak->tgl_batas_f }}</h4>
                                <span class="text-sm dark:text-gray-400">Deadline</span>
                            </div>
                        </div>

                        <!-- stat 3 -->
                        <div class="flex items-center gap-5">
                            <i data-lucide="users" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                            <div>
                                <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">{{ $kontrak->tenaga_ahlis->count() }}</h4>
                                <span class="text-sm dark:text-gray-400">Tenaga Ahli</span>
                            </div>
                        </div>

                        <!-- stat 3 -->
                        <div class="flex items-center gap-5">
                            <i data-lucide="clock-5" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                            <div>
                                <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">{{ now()->diffForHumans($kontrak->tgl_mulai) }}</h4>
                                <span class="text-sm dark:text-gray-400">Riwayat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-2 space-y-5">
            <div class="card">
                <div class="p-5 pb-0">
                    <h4 class="uppercase dark:text-gray-300">Tentang Pekerjaan/Kontrak</h4>
                </div>

                <div class="p-6">
                    <div>
                        <p class="text-gray-500 mb-4 text-sm dark:text-gray-400 font-bold">{{ $kontrak->nama }}</p>
                        <p class="text-gray-500 mb-4 text-sm dark:text-gray-400">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate laboriosam sunt eos expedita eligendi exercitationem accusantium, beatae doloribus deleniti numquam enim consequuntur vitae non, repellat voluptatum vero officiis temporibus quo quas inventore. Tenetur molestias facilis voluptates veniam nostrum veritatis vitae error ab eum? Illo consequatur quidem explicabo in, voluptate consectetur assumenda voluptatum reiciendis id dignissimos necessitatibus soluta aspernatur dolorem laboriosam quibusdam tempora iusto, accusantium aliquid quis nobis quos! Amet, eveniet. Molestiae debitis cupiditate exercitationem odio, vero veniam possimus autem porro sed libero fuga iure natus iste id quidem necessitatibus consequuntur? Maxime nulla numquam, aliquam voluptatum est voluptas exercitationem beatae commodi?
                        </p>
                        <p class="text-gray-500 mb-4 text-sm dark:text-gray-400 font-bold">Tenaga Ahli:</p>
                        <ul class="ps-9 mb-9 list-disc">
                            @foreach ($kontrak->tenaga_ahlis as $tenaga_ahli)
                            <li>{{ $tenaga_ahli->nama }}</li>
                            @endforeach
                        </ul>

                        <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-6">
                            <div class="">
                                <div class="">
                                    <p class="mb-3 text-sm uppercase font-medium"><i class="uil-envelope-alt text-red-500 text-base"></i> Email</p>
                                    <h5 class="text-base text-gray-700 dark:text-gray-300 font-medium">{{ $kontrak->badan_usaha->email }}</h5>
                                </div>
                            </div>
                            <div class="">
                                <p class="mb-3 text-sm uppercase font-medium"><i class="uil-phone text-red-500 text-base"></i> Telepon</p>
                                <h5 class="text-base text-gray-700 dark:text-gray-300 font-medium">{{ $kontrak->badan_usaha->telepon }}</h5>
                            </div>
                            <div class="">
                                <p class="mb-3 text-sm uppercase font-medium"><i class="uil-dialpad-alt text-red-500 text-base"></i> NPWP</p>
                                <h5 class="text-base text-gray-700 dark:text-gray-300 font-medium">{{ $kontrak->badan_usaha->npwp }}</h5>
                            </div>

                            <div class="">
                                <p class="mb-3 text-sm uppercase font-medium"><i class="uil-constructor text-red-500 text-base"></i> Pembuat Pekerjaan/Kontrak</p>
                                <h5 class="text-base text-gray-700 dark:text-gray-300 font-medium">{{ $kontrak->author->name }}</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-1">
            <div class="card">
                <div class="p-5 pb-0">
                    <h6 class="uppercase dark:text-gray-300">Aktivitas</h6>
                </div>

                <div class="p-6 pt-0">
                    <div class="divide-y divide-gray-100 dark:divide-gray-600">
                        <div class="flex items-start gap-5 py-3">
                            <div class="text-center">
                                <h2 class="h-9 w-9 rounded-full text-base flex items-center justify-center text-primary bg-primary/20">{{ $kontrak->tgl_selesai->isoFormat('D') }}</h2>
                                <small>{{ $kontrak->tgl_selesai->isoFormat('MMM') }}</small>
                            </div>
                            <div>
                                <p class="text-gray-700 block font-semibold dark:text-gray-300 mb-1">Status Pekerjaan/Kontrak</p>
                                <p class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium {{ $status }}">{{ $kontrak->status_kontrak }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="text-center">
                        <form action="{{ route('kontrak.selesai', $kontrak->slug) }}" method="post">
                            @method('put')
                            @csrf
                            <button type="button" id="selesaiData" data-title="{{ $kontrak->nama }}" class="border border-success/20 btn bg-success/20 text-success hover:bg-success hover:text-white py-2 px-3 rounded">
                                <i data-lucide="check" class="w-4 h-4 me-2"></i>Tandai Selesai
                            </button>
                        </form>
                    </div> <!-- end button -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<!-- Sweet-alert js  -->
<script src="/assets/js/sweetalert2.all.min.js"></script>

@if(session()->has('success'))
<script>
    $(document).ready(function() {
        let Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    });
</script>
@endif

<script>
	$(document).on('click', '#selesaiData', function() {
		let title = $(this).data('title');

		Swal.fire({
			title: 'Selesaikan ' + title + '?',
			html: "Apakah kamu yakin ingin menandai pekerjaan <b>" + title + "</b> sudah selesai dikerjakan?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Tandai selesai',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				$(this).closest('form').submit();
			}
		});
	});
</script>

@endsection