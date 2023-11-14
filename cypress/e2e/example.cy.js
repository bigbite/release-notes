
describe('no release notes found', () => {
  it('some release notes are published', () => {
    cy.visit('/wp-admin/admin.php?page=release-notes');
    cy.get('article.release-note-single').should('exist');
    cy.get('article.release-note-single h1.release-note-title').contains('Release not found!');
  });
});
