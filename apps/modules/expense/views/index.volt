{% extends "../layouts/base.volt" %}

{% block title %}Halaman Pengeluaran{% endblock %}

{% block content %}
<div id="page-container" class="sidebar-inverse side-scroll page-header-fixed main-content-boxed">
    <main id="main-container" style="padding-top: 5vw">
        <div class="content" style="padding-top: 0">
        <div id="hides" class="notif-block" style="height:5vh;  overflow-y: auto;">{{flashSession.output()}}</div>
        <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2>Kelola <b>Pengeluaran Laundry</b></h2></div>
            </div>
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <a href="#tambahPengeluaranModal"  class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i><span>Tambah Pengeluaran</span></a>
                    <a id="multi-uwus" href="#hapusPengeluaranModal" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash-o"></i><span>Hapus</span></a>						
                </div>
            </div>
        </div>
            {% if page != null %}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>No.</th>
                        <th>Catatan Pengeluaran</th>
                        <th>Total Pengeluaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                {% set i = 1 %}
                    {% for t in page %}
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox1" name="options" value="{{t.getId()}}">
                                    <label for="checkbox1"></label>
                                </span>
                            </td>
                            <td>{{offset + i}}</td>
                            <td>{{t.getExpenseNote()}}</td>
                            <td>{{t.getExpenseTotal()}}</td>
                            <td>
                                <!--change to button-->
                                <a href="#lihatInvoiceModal{{t.getId()}}" class="view" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Lihat"></i></a>
                                <a href="#editExpenseModal{{t.getId()}}" class="edit" data-toggle="modal" data-remote="{{url('edit/pickup_Expense?')}}"><i class="fa fa-pencil" data-toggle="tooltip" title="Ubah" value="{{t.getId()}}"></i></a>
                            </td>
                        </tr>
                    {% set i = i + 1 %}
                    {% endfor %}
                </tbody>
            </table>
            <div class="text-center text-lg">
                <a href='/expense' class="btn btn-info">First</a>
                {% if page_number - 1 >= 1 %}
                <a href='/expense?page={{page_number - 1}}' class="btn btn-info">Previous</a>
                {% endif %}
                {% if page_number + 1 <= page_last %}
                <a href='/expense?page={{page_number + 1 }}' class="btn btn-info">Next</a>
                {% endif %}
                <a href='/expense?page={{page_last}}' class="btn btn-info">Last</a>
                <p class="text-success"><b>Anda berada di halaman {{page_number}} dari {{page_last}}</b></p>
            </div>
            {% else %}
                <h2 class="text-danger text-center">Tidak ada data yang dapat ditampilkan</h2>
            {% endif %}
            </div>
        </div>
    <main>
</div>

<div id="tambahPengeluaranModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="ExpenseForm" action="add/expense" method="POST" enctype="multipart/form-data">
                <div class="modal-header">						
                    <h4 class="modal-title">Tambah Pengeluaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">									
                    <div class="form-group">
                        <label><b>{{form.getLabel('expense_note')}}</b></label>
                        {{form.render('expense_note')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{form.getLabel('expense_total')}}</b></label>
                        {{form.render('expense_total')}}
                    </div>
                    <div class="form-group">
                        <label><b>{{form.getLabel('invoice')}}</b></label>
                        {{form.render('invoice')}}
                    </div>								
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    {{form.render('Simpan')}}
                </div>
            </form>
        </div>
    </div>
</div>

<div id="hapusPengeluaranModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="expense" action="delete/expense" method="POST">
                <div class="modal-header">						
                    <h4 class="modal-title">Hapus Pengeluaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">				
                    <input type='hidden' value='' name='expense_id' id='expense_id'>
                    <p>Apakah Anda yakin untuk menghapus data yang telah dipilih ?</p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    <input type="submit" class="btn btn-danger" value="Hapus">
                </div>
            </form>
        </div>
    </div>
</div>

{% for t in page %}
<div id="editExpenseModal{{t.getId()}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update/expense" method="POST" enctype="multipart/form-data">
                <div class="modal-header">						
                    <h4 class="modal-title">Edit Pengeluaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="expense_id" name="expense_id" value="{{t.getId()}}">
                    <div class="form-group">
                        <label><b>Catatan Pengeluaran</b></label>
                        <p><textarea class="form-control" name="expense_note" id="expense_note">{{t.getExpenseNote()}}</textarea></p>
                    </div>
                    <div class="form-group">
                        <label><b>Total Pengeluaran</b></label>
                        <p><input type="text" class="form-control" name="expense_total" id="expense_total" value="{{t.getExpenseTotal()}}"></p>
                    </div>
                    <div class="form-group">
                        <label><b>Bukti Resi</b></label>
                        <p><input type="file" class="form-control" name="invoice" id="invoice"></p>
                    </div>						
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    <input type="submit" class="btn btn-success" id="Simpan" nama="Simpan" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>

<div id="lihatInvoiceModal{{t.getId()}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">						
                    <h4 class="modal-title">Bukti Resi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <embed src={{t.getInvoice()}} width="350px" height="500px">	
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                </div>
            </form>
        </div>
    </div>
</div>
{% endfor %}

{% endblock %}