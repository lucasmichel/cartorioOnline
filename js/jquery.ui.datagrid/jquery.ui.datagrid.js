/*!
 * jQuery datagrid
 * 
 * @autor:.....: Juarez Gonçalves Nery Junior
 * @email:.....: juareznjunior@gmail.com
 * @twitter:...: @juareznjunior
 * @date.......: 2014-01-29
 * 
 * Use jQueryUI - Depends:
 *	 jquery.ui.core.js
 *	 jquery.ui.widget.js
 *	 jquery.ui.button.js
 * 
 */
;(function($,window,document,undefined) {
	'use strict';

	var jQueryDataGrid = {
		options : {
			/**
			 * limit clause
			 */
			//limit: 210

			/**
			 * Data Mapper
			 * Usage:
			 * mapper:[{
			 *  name    : 'field_name'
			 *  ,title  : 'Field Title'
			 *  ,width  : 50
			 *  ,align  : 'center|left|right'
			 *  ,render : function(DOMCell,json.name,json) {}
			 * }]
			 *
			 */
			mapper: []

			/**
			 * Scroll height
			 */
			,height: 300

			/**
			 * Data store and ajax config
			 * $.ajax
			 *  param
			 *  url
			 *
			 * Local data
			 *  data
			 * 
			 */
			,jsonStore: {
				url: ''
				,params: {}
				,data: {}				
			}
			
			,pagination: true
			,refresh: false
			,rowNumber: false
                        ,uniqueRow: true // permite selecionar apenas uma linha
			,fit: false
			,autoRender: true
			,autoLoad: true

			/**
			 * AJAX Request method
			 */
			,ajaxMethod: 'GET'

			/**
			 * Datagrid title
			 */
			,title: ''

			/**
			 * Callback
			 *
			 * @context ui.datagrid
			 * @param row clicked
			 * @param event
			 */
			,onClickRow: false

			/**
			 * Callback
			 * After render grid template
			 *
			 * @context ui.datagrid
			 */
			,onComplete: false
			
			/**
			 * Callback
			 * After ajax Load (success)
			 * 
			 * @context ui.datagrid
			 */
			,onAjaxSuccess: false

			/**
			 * Callback
			 * Ajax Error
			 *
			 * @context ui.datagrid
			 */
			,onError: false

			/**
			 * empty rows, request or local data
			 */
			,emptyDataMessage: 'Empty rows'

			/**
			 * Usage:
			 * [{
			 *    text: 'My Button Label'
			 *   ,icon : 'arrowthickstop-1-s'
			 *   ,click   : function(button) {}
			 * }]
			 *
			 * click context: ui.datagrid
			 * click param: buttton
			 *
			 */
			,toolBarButtons: false
		}
		,_create: function() {                        
			// render container
			if ( this.element.css('display') === 'none' ) {
				this.element.show();
			}
		
			// helper
			var uiDataGridTables = [],contentScroll;
			
			// container datagrid
			this.uiDataGrid = $(getTemplateDataGrid( (undefined !== this.options.ui) ? 'ui' : 'bs' ));
			
			// tables in container
			this.uiDataGrid.find('table').filter(function(){
				if ( $(this).hasClass('ui-datagrid') ) {
					uiDataGridTables.push(this);
				} else {
					contentScroll = this.parentNode.parentNode;
				}
			}).end();

			// grid title
			if ( this.options.title === '' ) {
				$(contentScroll.parentNode).prev().remove();
			} else {
				$(contentScroll.parentNode).prev().children().text(this.options.title);
			}

			// remove tfoot if...
			if ( $.isArray(this.options.toolBarButtons) === false && this.options.pagination === false) {
				$(uiDataGridTables[2].parentNode).remove();
			}

			// setters
			this.uiDataGridThead      = $(uiDataGridTables[0].tHead);
			this.uiDataGridTheadBody  = $(uiDataGridTables[1].tHead);
			this.uiDataGridColGroup1  = this.uiDataGridThead.prev();
			this.uiDataGridColGroup2  = this.uiDataGridTheadBody.prev();
			this.uiDataGridTbody      = $(uiDataGridTables[1].tBodies[0]);
			this.uiDataGridMsgError   = $(uiDataGridTables[1]).parent().find('div.ui-state-error');
			this.uiDataGridTfoot      = (this.options.pagination || $.isArray(this.options.toolBarButtons)) ? $(uiDataGridTables[2].tBodies[0]) : $([]);
			this.uiDataGridScrollBody = $(uiDataGridTables[1].parentNode).height(this.options.height);
			this.uiDataGridScrollMain = $(contentScroll);

			// pagination cache elements
			// initial config
			this.uiDataGridTdPagination = {
				childs: []
			};

			// selected Row(s)
			this._selectedRows = [];

			// clear
			uiDataGridTables = contentScroll = null;
			
			// pagination params
			this._num_rows   = 0;
			this._offset     = 0;
			this._totalPages = 0;

			// grid events via data bind
			this.element.on('click.uiDataGridBindClick',':data(uiDataGridBindClick)',{uiDataGrid:this},function(event){
                                
				event.preventDefault();
				event.stopPropagation();

				var bindClick = $.data(this,'uiDataGridBindClick')
					,trigger;

				if ( undefined !== bindClick ) {
					if ( 'loadPage' === bindClick ) {
						
						if ( false === this.disabled ) {
							trigger = $(event.data.uiDataGrid.uiDataGridTdPagination.childs).filter('button');
                                                        
							if ( event.data.uiDataGrid.options.ui ) {                                                                
								trigger.removeClass('ui-state-hover ui-state-focus').button('disable');
							} else {
								trigger.prop('disabled',true);
							}
							
							trigger = this.name.split('-').slice(-1);
							event.data.uiDataGrid['_'+trigger+'Page']();
							event.data.uiDataGrid.load();
						}
					} else {
                                            
                                                
						trigger = event.data.uiDataGrid.options;
						
						$.map(bindClick.split(':'),function(a,b){
							trigger = trigger[a];
						});

						if ( $.isFunction(trigger) ) {                                                
							trigger.call(event.data.uiDataGrid.element[0],this);
						}
					}
				}                                
    				bindClick = trigger = null;
			});

			// create pagination, initial config
			// see _updatePagination()
			this._createPagination();
		}
		,_init: function() {                    
                        $("#spnDataGridTotal").html("Página: 0 de 0 (Total: 0)");
                        
			if (this.options.autoRender) {
				this.render();
			}
		}
		,_createColumns: function() {
			var self   = this
				,$auxTh = null
				,cells  = []
				,cols   = []
				,text   = null
				,sw     = 0
				,col    = '<col></col>'
				,th     = '<th class="ui-widget ui-state-default" role="columnheader"></th>'
				,al     = 'ui-datagrid-align-'
				,ch     = 'ui-datagrid-column-hide'
				,ui     = self.options.ui;
			
			// each mapper
			$.map(self.options.mapper,function(obj,index){
			
				text = obj.title || obj.name;
				sw += obj.width || 0;

				// remove tags
				$auxTh = $(th).html(text);
				$auxTh = $auxTh.text($auxTh.text());
				
				// align
				$auxTh.data('text-align',al+(( /left|right|center/.test(obj.align) ) ? obj.align : 'left')).addClass(function(){
					return $(this).data('textAlign');
				});

				if ( true === obj.sort ) {
					$auxTh
						.addClass('ui-datagrid-sort')
						.html(function(b){
							b = $('<button>'+this.innerHTML+'</button>',{type:'button'});
							if ( ui ) {
								b.button({icons:{primary:'',secondary:'ui-icon-carat-2-n-s'}});
							} else {
								b.addClass('btn btn-default').append('<span class="glyphicon glyphicon-sort"></span>');
							}
							return b;
						});
				}

				// append
				cols[cols.length]   = $(col).width(obj.width);
				cells[cells.length] = $auxTh[0];

				// hide column
				if ( undefined !== obj.hidden ) {
					$auxTh.data('hidden',ch).addClass(ch);
					$(cols).last().addClass(ch);
				};

			});

			// enable row number
			if (self.options.rowNumber) {
				cols.splice(0,0,$(col)[0]);
				cells.splice(0,0,$('<th class="ui-state-default ui-datagrid-cell-rownumber" role="columnheader"></th>')[0]);
				sw += 20;
			}

			// create colgroup cols
			$([self.uiDataGridColGroup1[0],self.uiDataGridColGroup2[0]])
				.empty() // update
				.append(cols.slice(0,-1));

			// create thead ths
			$([self.uiDataGridThead[0].rows[0],self.uiDataGridTheadBody[0].rows[0]])
				.empty() // update
				.append(cells);

			// correct column width
			$(self.uiDataGridThead[0].rows[0].cells).slice(0,-1).map(function(i,w){
				w = Math.max($(w).innerWidth(),$(w).outerWidth());
				self.uiDataGridColGroup1.children().eq(i).width(w);
				self.uiDataGridColGroup2.children().eq(i).width(w);
			});

			// enable overflow-y
			if ( sw > self.element.width() ) {
				self.uiDataGridScrollMain.width(sw);
			}

			// grid layout
			$(self.uiDataGridTbody[0].parentNode).map(function(i,t){
				
				// if exists
				i = $(t.parentNode).find('.ui-datagrid-gridlayout');
				( i.length > 0 && i.remove() );

				// clone table
				t = $(t)
					.clone()
					.addClass('ui-datagrid-gridlayout')
					.removeClass('table-hover')
					.find('tbody')
					.append('<tr><td class="ui-widget ui-widget-content">&nbsp;'+Array(t.tHead.rows[0].cells.length).join('</td><td class="ui-widget ui-widget-content">&nbsp;')+'</td></tr>')
					.end()
					.prependTo(t.parentNode);

				$(t[0].tHead).remove();

				// update class if rowNumber
				if ( self.options.rowNumber ) {
					t[0].tBodies[0].rows[0].cells[0].className = 'ui-state-default ui-datagrid-cell-rownumber';
				}
				
				t = i = null;

			});

			$(self.uiDataGridTheadBody[0].parentNode.tHead).hide();
			
			cells = $auxTh = self = col = cols = th = al = null;
		}
		,_createRows: function(json,origin,appendRow) {                    
			var self             = this
				,theadThs        = self.getThead()[0].rows[0].cells
				,oTbody          = appendRow ? self.uiDataGridTbody[0] : self.uiDataGridTbody.empty()[0]
				,cls             = 'ui-widget ui-widget-content'
				,offset          = appendRow ? (oTbody.rows.length + 1) : (self._offset + 1)
				,localPagination = (!appendRow && 'local' === origin && self.options.pagination)
				,ui              = self.options.ui
				,row
				,cell;

			// set _num_rows
			if ( self._num_rows === 0 ) {
				self._num_rows = ( undefined === json.num_rows )
					? ( undefined === json.rows )
						? ( undefined === json[0].num_rows )
							? json.length
							: json[0].num_rows
						: ( undefined === json.rows[0].num_rows )
							? json.rows.length
							: json.rows[0].num_rows
					: json.num_rows;
			}

			// correct JSON
			json = json.rows || json;

			// local pagination
			if ( localPagination && offset > 1) {
				// seek?
				json = json.slice(self._offset);
			}

			$.map( json ,function(obj,i){

				// break
				//if ( localPagination && i === self.options.limit ) {                                
				if ( localPagination && i === self.options.jsonStore.params.limit ) {
					return false;
				}
			
				// tr
				row           = oTbody.insertRow(-1);
				row.className = ui ? 'ui-state-hover' : '';

				
				$(row)
					// create row data, using current json mapper
					.data('row-json',obj)
					// create row data, offset index
					.data('row-index',(offset + 1));
			
				// row number
				if ( self.options.rowNumber ) {
					$(row.insertCell(0)).addClass('ui-state-default ui-datagrid-cell-rownumber').text((offset + i));
				}

				// onClickRow
				if ( $.isFunction(self.options.onClickRow) ) {
					$(row).data('uiDataGridBindClick','onClickRow');
				}
				
				// tds
				$.map(self.options.mapper,function(td,j){
					cell = row.insertCell(-1);
					cell.className = cls;

					// column classes
					$.map($(theadThs[cell.cellIndex]).data(),function(v,k){
						if ( /textAlign|text-align|hidden/.test(k) ) {
							cell.className += ' '+v;
						}
					});

					// render
					$(cell)
						.html(
							$.isFunction(td.render)
								// if options.render is a function
								// @context cell
								// @param content
								? td.render.call(cell,obj[td.name])

								// default
								// mapper.row.fieldName
								: obj[td.name]
						);
				});
			});
                        
			if ( !appendRow ) {
				// update paginantion
				this._updatePagination();

				// reset scroll
				self.uiDataGridScrollBody.scrollTop(0);
			}
			
			theadThs = oTbody = row = cell = self = json = null;
		}
		,_createPagination: function() {

			if ( true === this.options.pagination ) {

				var self = this
					,td = $(this.uiDataGridTfoot[0].rows[0].cells).last()[0]
					,ui = self.options.ui
					,bsicons = ['step-backward','backward','forward','step-forward']
					,i;

				// add dom span
				self.uiDataGridTdPagination.childs.push($(td).children()[0]);

				// create pagination buttons
				$.map(['first','prev','next','end'],function(n,b){

					i = b;

					b = $('<button></button>',{type:'button',name:'uiDataGridSetPage-'+n,disabled:true}).text(n);

					if ( ui ) {
						b.button({
							icons: { primary: 'ui-icon-seek-'+n}
							,text: false
						});
					} else {
						b.addClass('btn btn-default btn-xs').html('<span class="glyphicon glyphicon-'+bsicons[i]+'"></span>');
					}

					b.data('uiDataGridBindClick','loadPage').appendTo(td);

					// add dom button
					self.uiDataGridTdPagination.childs.push(b[0]);

					b = null;
				});

				self = td = bsicons = null;
			}

		}
		,_updatePagination: function() {

			var currentPage
				,infoPages;

			// 
			// using keys num_rows and rows
			// {"num_rows": number,rows:[{"foo":"bar","date":date},{"foo":"bar","date":date}]}
			//
			// using num_rows within mapper
			// [{"num_rows":number,"foo":"bar","date":date}]
			//
			// disable pagination via request
			// [{"foo":"bar","date":date},{"foo":"bar","date":date},{"foo":"bar","date":date}]
			// [] | {}
			//

			if ( this.options.pagination && this._num_rows ) {

				// setters
				//this._totalPages = Math.ceil(this._num_rows / this.options.limit);
				this._totalPages = Math.ceil(this._num_rows / this.options.jsonStore.params.limit);
				//currentPage      = (this._offset === 0 ) ? 1 : ((this._offset / this.options.limit) + 1);
				currentPage      = (this._offset === 0 ) ? 1 : ((this._offset / this.options.jsonStore.params.limit) + 1);
				infoPages        = 'Página: ' + currentPage+' de '+this._totalPages+' (Total: '+this._num_rows+')';

				(function(self){
					$.map(self.uiDataGridTdPagination.childs,function(b){
						if (/span/i.test(b.tagName)) {
							// update info
							$(b).text(infoPages);
						} else {
							// enable buttons
							( /uiDataGridSetPage-(first|prev)/.test(b.name) )
								? (self._offset > 0 && b.disabled && (self.options.ui ? $(b).button('enable') : $(b).prop('disabled',false)) )
								: (self._totalPages > currentPage && (self.options.ui ? $(b).button('enable') : $(b).prop('disabled',false)) );
						}
					});
				}(this));
			}
		}
		,_createToolBarButtons: function() {

			if ( $.isArray(this.options.toolBarButtons) ) {

				// cell to append btns
				var self = this
					,cell = this.uiDataGridTfoot[0].rows[0].cells[0]
					,ui = self.options.ui;

				// each button
				$.map(self.options.toolBarButtons,function(obj,idx){

					var $button = $('<button></button>',{type:'button'});

					obj.text  = obj.label || obj.text;
					obj.click = obj.fn || obj.click;

					delete obj.fn;
					delete obj.label;

					if ( $.isFunction(obj.click) ) {
						$button.data('uiDataGridBindClick','toolBarButtons:'+idx+':click');
					}

					$button.text(obj.text);

					if ( ui ) {
						$button.button({
							icons: {
								primary: (undefined === obj.icon) ? null : 'ui-icon-'+obj.icon
							}
						});
					} else {
						$button.addClass('btn btn-default btn-xs');
						if ( undefined !== obj.icon ) {
							$button.prepend('<span class="glyphicon glyphicon-'+obj.icon+'"></span> ');
						}
					}

					$button.appendTo(cell);
				});

				cell = self = null;
			}
		}
		,_nextPage: function() {
			//this._offset += this.options.limit;
			this._offset += this.options.jsonStore.params.limit;
		}
		,_prevPage: function() {
			//this._offset -= this.options.limit;
			this._offset -= this.options.jsonStore.params.limit;
		}
		,_endPage: function() {
			this._offset = (this._totalPages * this.options.jsonStore.params.limit) - this.options.jsonStore.params.limit;
			//this._offset = (this._totalPages * this.options.limit) - this.options.limit;
		}
		,_firstPage: function() {
			this._offset = 0;
		}
		,_active: function() {
			return this.element.children(':eq(0)').hasClass('ui-datagrid-container');
		}
		,_getBHF: function(bfh,callback) {                        
			return ($.isFunction(callback))
				? callback.call(bfh[0])
				: bfh;
		}
		,_message: function(m) {
			this.uiDataGridTbody.empty();
			this.uiDataGridMsgError.text(m).addClass('show-message');
		}
		,_ajax: function() {   
                        preLoadingOpen(null);
			var o      = this.options;
                        var url    = o.jsonStore.url;
                        var limit  = o.limit;
                        var offset = this._offset;
                        var store  = o.jsonStore;
			
			// clear selected rows
			this.clearSelectedRows();
			
			// hide error msgs
			this.uiDataGridMsgError.removeClass('show-message');

			// local data
			if ( undefined === url || '' === url ) {

				// valid JSON
				url = (store.data.rows || store.data)[0];

				if ( undefined === url  || undefined === url[o.mapper[0].name] ) {
					this._message('Invalid JSON or empty data');
				} else {
					// create rows
					this._createRows(store.data,'local');
				}

				url = null;

				return;
			}
			
			// serialize
			// literal object (isPlainObject (json))
			if ('string' === typeof store.params) {
				store.params = (0 === offset)
					? store.params+'&limit='+store.params.limit+'&offset='+offset
					: store.params.replace(/(&offset=)(.+)/,'&offset='+offset);
			} else {
			
				// ex: obj.datagrid('option','jsonStore',{url:'foo/bar'})
				if ( undefined === store.params ) {
					store.params = {};
				}
				
				// normalize
				store.params.limit = store.params.limit;
				store.params.offset = offset;
			}			
			//console.log(this.options.jsonStore.params.limit);
			//console.log(this.options);
			// ajax
			$.ajax({
				type: o.ajaxMethod.toLowerCase()
				,url: url.replace(/\?.*/,'')
				,data: store.params
				,dataType: 'json'
				,context: this
				,success: function(json) {
                                        preLoadingClose();
					if ( undefined !== json.error || 0 === json.length  ) {
						
						json = (undefined !== json.error)
							? json.error
							: ( json.length === 0 )
								? this.options.emptyDataMessage
								: 'Invalid JSON';
								
						if ( $.isFunction(this.options.onError) ) {
							this.options.onError.call(this.element[0],json);
						} else {
							this._message(json);
						}

						return false;
					}
					
					// create rows
                                        if(json.sucesso == "true"){
                                            this._createRows(json,'ajax');
                                            ( $.isFunction(this.options.onAjaxSuccess) && this.options.onAjaxSuccess.call(this.element[0]) );                                            
                                        }else{
                                            this.uiDataGridTbody.empty();
                                        }
				}
			});
		}
		,render: function() {
			var self = this,delay = 0;
			
			if ( self._active() ) {                            
				self.resetOffset();
				// self.load(); // RETIRADO
			} else {
				
				// config buttons
				self._createToolBarButtons();
				
				// create ui-datagrid
				self.uiDataGrid.appendTo(self.element);
				
				// create columns
				self._createColumns();
				
				// resize
				self.resize();

				// load
				if ( self.options.autoLoad ) {
					delay = 180;
					// delay
					setTimeout((function(ui){
						return function() {
							ui.load();
						};
					}(self)),delay);
				}
				
				// onComplete callback
				if ( $.isFunction(self.options.onComplete) ) {
					// delay
					setTimeout((function(ui){
						return function(){
							ui.options.onComplete.call(ui.element[0]);
						};
					}(self)),(delay++));
				}
			}

			self = null;
		}
		,resize: function() {
			// fit to parent
			if ( this.options.fit ) {
				(function(self){
					var h = self.uiDataGrid.outerHeight() - self.element.height();
					this.style.height = $(this).height() - h +'px';
				}).call(this.uiDataGridScrollBody[0],this);
			}
		}
		,selectRow: function(row) {                        
                        if(this.options.uniqueRow){
                            this.clearSelectedRows();
                        }
                        
			var self = this
				,idx= $.inArray(row,this._selectedRows);
				
			if ( idx > -1 ) {
				this._selectedRows.splice(idx,1);
				$(row).removeClass('ui-state-highlight');
			} else {
				this._selectedRows.push(row);
				$(row).addClass('ui-state-highlight');
			}
                        
			self = null;
		}
		,clearSelectedRows: function() {
			this.getSelectedRows(true).removeClass('ui-state-highlight');
			this._selectedRows = [];
		},selectAllRows: function() {
                    // CRIADO
                    for(var i=0; i<this.uiDataGridTbody[0].rows.length; i++){                        
                        this.selectRow(this.uiDataGridTbody[0].rows[i]);
                        //this.uiDataGridTbody[0].rows[i].addClass('ui-state-highlight'); ui-state-hover
                        //$(this.uiDataGridTbody[0].rows[i]).removeClass('ui-state-hover');
                        //$(this.uiDataGridTbody[0].rows[i]).addClass('ui-state-highlight');
                    }
                    
                    
			/*this.getSelectedRows(true).removeClass('ui-state-highlight');
			this._selectedRows = [];*/
		}
                ,clearAllRows: function() {
                    // CRIADO
                    for(var i=0; i<this.uiDataGridTbody[0].rows.length; i++){                        
                        $(this.uiDataGridTbody[0].rows[i]).removeClass('ui-state-highlight');                        
                    }
                    
                    this._selectedRows = [];
		}
		,getSelectedRows: function(obj) {                         
			return ( true === obj ) ? $(this._selectedRows) : this._selectedRows;
		}
		,load: function() {                    
			this._ajax();
		}
		,widget: function() {
			return this.uiDataGrid;
		}
		,getOffset: function() {
			return this._offset;
		}
		,resetOffset: function() {
			var b;
			this._num_rows = 0;
			this._offset = 0;
			if ( true === this.options.pagination ) {
				// disable pagination buttons
				b = $(this.uiDataGridTdPagination.childs).filter('button');
				( this.options.ui )
					? b.button('disable')
					: b.prop('disabled',true);
			}
		}
		,getThead: function(callback) {
			return this._getBHF(this.uiDataGridThead,callback);
		}
		,getTbody: function(callback) {
			return this._getBHF(this.uiDataGridTbody,callback);
		}
		,getTFoot: function(callback) {
			return this._getBHF(this.uiDataGridTfoot,callback);
		}
		,addRow: function(json) {
			this._createRows(json,null,true);
		}
		,loadLocalData: function(json,callback) {
			this.resetOffset();
			this.options.jsonStore = {
				url: ''
				,params: {}
				,data: json
			};

			this.load();
			( $.isFunction(callback) && callback.call([]) );
		}
		,updateColumns: function(newMapper) {
			this.options.mapper = newMapper;
			this.uiDataGridTbody.empty();
			this._createColumns();
			this.resetOffset();
		}
	};
    
	var getTemplateDataGrid = function(css) {

		var fw = {
			ui: {
				 container_cls: 'ui-widget ui-widget-content ui-corner-all'
				,title_element: '<div class="ui-datagrid-title"><div class="ui-widget-header">Title</div></div>'
				,table_cls: ''
				,table_row_hover: ''
			}
			,bs: {
				 container_cls: 'panel panel-default'
				,title_element: '<div class="ui-datagrid-title panel-heading">Title</div>'
				,table_cls: 'table table-bordered table-condensed'
				,table_row_hover: ' table-hover'
			}
		};

		fw = fw[ (/^(ui|bs)$/.test(css) ? css : 'ui') ];

		var html =  '<div class="ui-datagrid-container '+fw.container_cls+'">'
			+fw.title_element
			+'<div class="ui-datagrid-content">'
				+'<div class="ui-datagrid-content-scroll">'
					+'<div class="ui-datagrid-header ui-state-default">'
						+'<table class="table">'
							+'<thead>'
								+'<tr>'
									+'<th class="active">'
										+'<table class="ui-datagrid '+fw.table_cls+'">'
											+'<colgroup></colgroup>'
											+'<thead>'
												+'<tr role="rowheader" class="active"></tr>'
											+'</thead>'
										+'</table>'
									+'</th>'
									+'<th class="active"></th>'
								+'</tr>'
							+'</thead>'
						+'</table>'
					+'</div>'
					+'<div class="ui-widget-content ui-datagrid-body">'
						+'<table class="ui-datagrid ui-front'+fw.table_cls+fw.table_row_hover+'">'
							+'<colgroup></colgroup>'
							+'<thead>'
								+'<tr role="rowheader"></tr>'
							+'</thead>'
							+'<tbody></tbody>'
						+'</table>'
						+'<div class="ui-state-error ui-front"></div>'
					+'</div>'
				+'</div>'
			+'</div>'
			+'<div class="ui-widget ui-state-default ui-datagrid-tools">'
				+'<table class="ui-datagrid '+fw.table_cls+'">'
					+'<tbody>'
						+'<tr>';
							// +'<td>&nbsp;</td>'
                                                        if(true){                                                            
                                                            html += '<td style="width: 70%"  >'
                                                            + '<select id="numlines" class="ui-datapicker-numlines" style="margin-left: 5px; margin-right: 5px; width: 100px;">'
                                                                + '<option value="20">20</option>'
                                                                + '<option value="40">40</option>'
                                                                + '<option value="60">60</option>'
                                                                + '<option value="80">80</option>'
                                                                + '<option value="100">100</option>'
                                                            + '</select>'
                                                            + '</td>';
                                                        }else{
                                                            html += '<td>&nbsp;</td>';
                                                        }                                                        
                                                        
							html+='<td style="width: 30%" ><span id="spnDataGridTotal"></span></td>'
						+'</tr>'
					+'</tbody>'
				+'</table>'
			+'</div>'
		+'</div>';
        
            return html;
	};

	// expose jquery plugin
	if ( $.widget ) {

		var JQUERY_UI_VERSION = Number($.ui.version.replace(/[^0-9]/g,''));

		$.widget('ui.datagrid',{
			_setOption: function(option,value) {
				if ( 'jsonStore' === option && $.isPlainObject(value) ) {
					this.options.jsonStore = $.extend({},this.options.jsonStore,value);
				} else {
					( JQUERY_UI_VERSION >= 1.9 )
						? this._super(option,value)
						: $.Widget.prototype._setOption.apply(this,arguments);
				}
			}
			,_destroy: function() {

				if ( JQUERY_UI_VERSION < 1.9 ) {
					$.Widget.prototype.destroy.call(this);
				}

				this.element.empty();
			}
		});

		jQueryDataGrid.options.ui = true;
		$.widget('ui.datagrid',$.ui.datagrid,jQueryDataGrid);
		jQueryDataGrid = null;

	} else {

		$.extend( $.expr[ ":" ], {
			data: $.expr.createPseudo ?
				$.expr.createPseudo(function( dataName ) {
					return function( elem ) {
						return !!$.data( elem, dataName );
					};
				}) :
				// support: jQuery <1.8
				function( elem, i, match ) {
					return !!$.data( elem, match[ 3 ] );
				}
		});

		$.fn.datagrid = function(options,get,set) {

			var returnValue = this;

			this.each(function(data,elem){

				data = $.data(this,'jQueryDataGrid');
				elem = this;

				if ( undefined === data ) {
		     		$.data(this,'jQueryDataGrid',(function(){
		     			this.options = $.extend({},this.options,options);
		     			this.element = $(elem);
		     			this.ui = false;
		     			this._create();
		     			this._init();
		     			return this;
		     		}).call(jQueryDataGrid));

				} else {

					var isMethodCall = (typeof options === "string")
						,methodValue
						,instance = data;

					if ( isMethodCall ) {

						if ( 'option' === options ) {
							if ( undefined !== get ) {
								if ( undefined !== set ) {
									instance.options[get] = ( $.isPlainObject(set) )
										? $.extend({},instance.options[get],set)
										: set;
								} else {
									returnValue = instance.options[get];
								}
							}
						} else {
							methodValue = instance[ options ].apply( instance, [options]);

							if ( methodValue !== instance && methodValue !== undefined ) {
								returnValue = methodValue && /^get/i.test(options)
									? methodValue
									: returnValue.pushStack( methodValue.get() );
							}
						}

						methodValue = instance = null;
					}
				}

				data = elem = null;
			});

			return returnValue;
		};
	}

}(jQuery,window,document));