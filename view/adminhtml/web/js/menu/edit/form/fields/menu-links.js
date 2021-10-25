define([
    'jquery',
    'mage/translate',
    'Naxero_MenuManager/js/helper/modal',
    'Naxero_MenuManager/js/helper/template',
    'Naxero_MenuManager/js/helper/tools',
    'jqtree',
    'domReady!'
], function ($, __, MMModal, MMTemplate, MMTools) {
    'use strict';

    return {
        /**
         * Table instance holder.
         */
        t: '#mm-tree',
 
        /**
         * Table message container holder.
         */
        messageContainer: '#mm-tree-messages',

        /**
         * Current menu ID.
         */
        menuId: null,

        /**
         * Current AJAX request.
         */
        currentRequest: null,

        /**
         * Cache holder.
         */
        cache: {
            category: [],
            product: [],
            page: []
        },

        /**
         * Build the table.
         */
        buildTable: function (config, menuLinks, menuId) {
            // Prepare parameters
            this.config = config;
            this.menuId = menuId;
            var self = this;

            // Initialise the table
            $(this.t).tree({
                data: menuLinks,
                autoOpen: true,
                dragAndDrop: true,
                autoEscape: false,
                onCreateLi: function (node, $li) {
                    // Add the row content
                    $li.find('.jqtree-element').append(
                        MMTemplate.getTemplate('link_row', {
                            node: node,
                            menuId: menuId,
                            config: config
                        })
                    );

                    // Prepare select lists variables
                    var rowId = '#mm-tree-row-' + node.id;
                    var linkTypeField = $li.find('.jqtree-element ' + rowId + ' .mm-link-type');
                    var linkUrlField = $li.find('.jqtree-element ' + rowId + ' .mm-link-url');
                    var linkTextField = $li.find('.jqtree-element ' + rowId + ' .mm-link-text');
                    var linkConfigField = $li.find('.jqtree-element ' + rowId + ' .mm-link-config');
                    var linkUrlOptionsContainer = $li.find('.jqtree-element ' + rowId + ' .mm-link-url-results');
                    var linkUrlFieldContainer = $li.find('.jqtree-element ' + rowId + ' .mm-link-url-field');
                    var activeButton = $li.find('.jqtree-element ' + rowId + ' .mm-action-active a');
                    var addRowButton = $li.find('.jqtree-element ' + rowId + ' .mm-icon-add a');
                    var linkConfigButton = $li.find('.jqtree-element ' + rowId + ' .mm-action-config');

                    // Config form button
                    linkConfigButton.on('click touch', function (e) {
                        // Prepare parameters
                        var url = window.BASE_URL + 'ajax/linkconfig';
                        var params = {
                            entity_id: node.id,
                            menu_id: menuId,
                            form_key: window.FORM_KEY
                        };
    
                        // AJAX request
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: params,
                            dataType: 'json',
                            beforeSend: function () {
                                $('body').trigger('processStart');
                            },
                            success: function (html) {
                                $('body').trigger('processStop');
                                var rowConfigId = '#mm-row-config-' + node.id;
                                MMModal.linkConfigForm(rowConfigId, node.id);
                                MMModal.showModal(html);
                            },
                            error: function (request, status, error) {
                                $('body').trigger('processStop');
                                console.log(error);
                            }
                        });
                    });

                    // Active button
                    activeButton.on('click touch', function (e) {
                        var field = $(e.target).data('field');
                        var newState = (parseInt(node.active) == 1 ? 0 : 1);
                        self.updateNodeBranch(node, newState, field);
                    });

                    // Add row button
                    addRowButton.on('click touch', function (e) {
                        var newNode = self.getEmptyRow(node);
                        $(self.t).tree('addNodeAfter', newNode, node);
                    });

                    // Link config field
                    linkConfigField.on('change', function (e) {
                        self.updateNode(node, [{
                            field: $(e.target).data('field'),
                            value: $(e.target).val()
                        }]);
                    });
                    
                    // Link text field
                    linkTextField.on('change', function (e) {
                        self.updateNode(node, [{
                            field: $(e.target).data('field'),
                            value: $(e.target).val()
                        }]);
                    });
                
                    // Link type field
                    linkTypeField.on('change', function (e) {
                        // Prepare the node
                        node['link_type'] = $(this).val();

                        // Clear the link URL field
                        linkUrlField.val('');

                        // Handle search suggestions
                        if (self.canTriggerSearch(node)) {
                            // Show the spinner
                            linkUrlFieldContainer.find('.mm-icon-spinner').css('display', 'block');

                            // Load the list options
                            self.loadListOptions(node);

                            // Show the results
                            linkUrlOptionsContainer.empty();
                            linkUrlOptionsContainer.css('display', 'block');
                        }
                    });

                    // Link URL field click event
                    linkUrlField.on('click touch', function (e) {
                        if (self.canTriggerSearch(node)) {
                            // Show the spinner
                            linkUrlFieldContainer.find('.mm-icon-spinner').css('display', 'block');

                            // Load the list options
                            self.loadListOptions(node);

                            // Show the results
                            linkUrlOptionsContainer.css('display', 'block');
                        }
                    });

                    // Link URL field on change event
                    linkUrlField.on('change', function (e) {
                        // Hide the results
                        linkUrlOptionsContainer.css('display', 'none');

                        // Update the node
                        self.updateNode(node, [
                            { field: 'link_url', value: $(this).val() },
                            {
                                field: 'link_data',
                                value: { text: $(this).val(), value: $(this).val() }
                            }
                        ]);
                    });

                    // Link URL field on input event
                    $(document).on('input', '.mm-link-url', function (e) {
                        var targetNodeId = $(e.target).parents('.mm-tree-row').data('node-id');
                        if (targetNodeId == node.id) {
                            var searchValue = $(this).val().toLowerCase();
                            var options = linkUrlFieldContainer.find('.mm-list-option');
                            if (options.length > 0) {
                                // Get the search suggestions
                                var searchResults = 0;
                                options.each(function () {
                                    var optionText = $(this).text().toLowerCase();
                                    if (optionText.indexOf(searchValue) == -1) {
                                        $(this).hide();
                                    } else {
                                        $(this).show();
                                        searchResults++;
                                    }
                                });
    
                                // Handle no suggestions (show all)
                                if (searchResults == 0) {
                                    options.each(function () {
                                        $(this).show();
                                    });
                                }
                            }
                        }
                    });

                    // Link URL list option click
                    $(document).on('click touch', '.mm-list-option', function (e) {
                        var targetNodeId = $(e.target).parents('.mm-tree-row').data('node-id');
                        if (targetNodeId == node.id) {
                            // Hide the results
                            linkUrlOptionsContainer.css('display', 'none');

                            // Update the text field value
                            linkUrlField.val($(this).data('text'));

                            // Update the node
                            self.updateNode(node, [
                                { field: 'link_url', value: $(this).data('value') },
                                {
                                    field: 'link_data',
                                    value: { text: $(this).data('text'), value: $(this).data('value') }
                                }
                            ]);
                        }
                    });
                }
            });

            // Row move event
            $(this.t).on('tree.move', function (e) {
                // Perform the move
                e.move_info.do_move();

                // Update the node paren
                var node = e.move_info.moved_node;
                var parentId = node.parent.entity_id ?? 0;
                self.updateNode(node, [
                    { field: 'parent_id', value: parentId }
                ]);
            });

            // Global add row event
            $('#mm-button-add').on('click touch', function (e) {
                self.addNode();
            });

            // Global delete row event
            $('#mm-button-del').on('click touch', function (e) {
                var node = $(self.t).tree('getSelectedNode');
                if (!node) {
                    $(self.messageContainer).empty().html(
                        MMTemplate.getTemplate('error_message', {
                            data: { msg: __('Please select a row to delete.') }
                        })
                    ).show().delay(2500).fadeOut();
                } else {
                    // Delete the row
                    $(self.t).tree('moveDown');
                    $(self.t).tree('removeNode', node);
                }
            });

            // Global generate rows event
            $('#mm-button-generate').on('click touch', function (e) {
                MMModal.generateLinksForm(
                    '#mm-generator-form',
                    self.generateAction
                );
                MMModal.showModal();
            });

            // Global Link URL click out event
            $('body').on('click touch', function (e) {
                if (!$(e.target).hasClass('mm-link-url')) {
                    $('.mm-link-url-results').css('display', 'none');
                }
            });
        },

        /**
         * Update a node branch state
         */
        updateNodeBranch: function (node, newValue, field) {
            // Update the node
            this.updateNode(node, [{
                field: field,
                value: newValue
            }]);

            // Handle children
            if (node.children.length > 0) {
                for (var i= 0; i < node.children.length; i++) {
                    // Update the child node
                    var child = node.children[i];
                    this.updateNode(child, [{
                        field: field,
                        value: newValue
                    }]);

                    // Update children recursively
                    this.updateNodeBranch(child, newState, field);
                }
            }
        },

        /**
         * Generate links action
         */
        generateAction: function () {
            // Prepare parameters
            var targetForm = window.parent.document.getElementById('mm-generate-form');
            $(targetForm).submit();
        },

        /**
         * Check if a node field an trigger AJAX search.
         */
        canTriggerSearch: function (node) {
            return node['link_type'] != 'custom'
            && node['link_type'] != 'external';
        },

        /**
         * Update a node data.
         */
        updateNode: function (node, data) {
            // Prepare the optional data
            data = data || null;

            // Update provided fields
            if (data) {
                for (var i = 0; i < data.length; i++) {
                    if (data[i].field == 'link_data') {
                        node[data[i].field] = JSON.stringify(data[i].value);
                    } else {
                        node[data[i].field] = data[i].value;
                    }
                }
            }

            // Hidden name field
            node['name'] = node['link_text'];

            // Update the node
            $(this.t).tree('updateNode', node);
        },

        /**
         * Load a select list options.
         */
        loadListOptions: function (node) {
            // Prepare variables
            var self = this;
            var options = self.cache[node['link_type']];

            // Load the list options
            if (options && options.length > 0) {
                this.buildListOptions(node, options);
            } else {
                // Request parameters
                var params = {
                    node: MMTools.getNodeData(node, this.config),
                    form_key: window.FORM_KEY
                };

                // Ajax request
                this.currentRequest = $.ajax({
                    type: 'POST',
                    url: window.BASE_URL + 'ajax/linkurloptions',
                    data: params,
                    beforeSend : function () {
                        if (self.currentRequest != null) {
                            self.currentRequest.abort();
                        }
                    },
                    success: function (res) {
                        self.buildListOptions(node, res);
                    },
                    error: function (request, status, error) {
                        console.log(error);
                    }
                });
            }
        },

        /**
         * Build a select list options.
         */
        buildListOptions: function (node, res) {
            // Prepare variables
            var html = '';
            var rowId = '#mm-tree-row-' + node.id;

            // Handle the result
            if (res.success) {
                var data = res.data;
                for (var i = 0; i < data.length; i++) {
                    // Set the option state
                    var selected = parseInt(node['link_url']) == parseInt(data[i].value)
                    ? 'selected' : '';

                    // Prepare the template parameters
                    var option = {
                        value: data[i].value,
                        text: data[i].text,
                        selected: selected
                    };

                    // Render the option
                    html += MMTemplate.getTemplate('list_option', { option: option });

                    // Hide any spinner
                    $('.mm-icon-spinner').css('display', 'none');
                }

                // Cache the data
                this.cache[node['link_type']] = data;

                // Render the result
                $(rowId).find('.mm-link-url-results').empty().html(html);
            } else {
                // Render the error
                $('#mm-tree-messages').empty().html(res.msg);
            }
        },

        /**
         * Add a node to the tree.
         */
        addNode: function () {
            // Prepare variables
            var self = this;
            var selectedNode = $(self.t).tree('getSelectedNode');
            var data = self.getEmptyRow(selectedNode);

            // Add the new node
            if (selectedNode) {
                $(self.t).tree('addNodeAfter', data, selectedNode);
            } else {
                $(self.t).tree('appendNode', data);
            }
        },

        /**
         * Update the links JSON hidden form field.
         */
        updateLinksField: function () {
            // Prepare the data
            var data = $(this.t).tree('toJson');

            // Update the hidden form field
            $('input#menu_links').val(data);
        },

        /**
         * Build an empty node row.
         */
        getEmptyRow: function (node) {
            // Prepare variarbles
            var uid = Date.now().toString(36) + Math.random().toString(36).substr(2);
            var fields = this.config.entity.link;
            var data = {};

            // Prepare the node fields
            for (var i = 0; i < fields.length; i++) {
                data[fields[i]] = '';
            }

            // Build the row data
            data.id = uid;
            data.entity_id = uid;
            data.menu_id = this.menuId;
            data.parent_id = node ? node.parent_id : 0;
            data.active = 1;
            data.children = [];
            data.link_data = JSON.stringify([{text: '', value: ''}]);
            data.link_config = JSON.stringify([]);

            return data;
        }
    };
});