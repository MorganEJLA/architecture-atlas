import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

function Edit() {
	return (
		<p { ...useBlockProps() }>
			{ __( 'Timeline block (placeholder)', 'atlas' ) }
		</p>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
