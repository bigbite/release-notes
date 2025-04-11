import CustomBlockFields from './CustomBlockFields';

const { registerPlugin } = wp.plugins;

registerPlugin('release-notes-meta', {
  icon: null,
  render: CustomBlockFields,
});
