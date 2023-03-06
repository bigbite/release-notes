import Edit from './edit';

const { registerBlockType } = wp.blocks;

registerBlockType('release-notes/markdown-parser', {
  edit: Edit,
  save: () => null,
});
